<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */


namespace Doctrine\DBAL;

use Doctrine\DBAL\Connection;

/**
 * Utility class that parses sql statements with regard to types and parameters.
 *
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.doctrine-project.com
 * @since       2.0
 * @author      Benjamin Eberlei <kontakt@beberlei.de>
 */
class SQLParserUtils
{
    /**
     * Get an array of the placeholders in an sql statements as keys and their positions in the query string.
     *
     * Returns an integer => integer pair (indexed from zero) for a positional statement
     * and a string => int[] pair for a named statement.
     *
     * @param string $statement
     * @param bool $isPositional
     * @return array
     */
    static public function getPlaceholderPositions($statement, $isPositional = true)
    {
        $match = ($isPositional) ? '?' : ':';
        if (strpos($statement, $match) === false) {
            return array();
        }

        $count = 0;
        $inLiteral = false; // a valid query never starts with quotes
        $stmtLen = strlen($statement);
        $paramMap = array();
        for ($i = 0; $i < $stmtLen; $i++) {
            if ($statement[$i] == $match && !$inLiteral && ($isPositional || $statement[$i+1] != '=')) {
                // real positional parameter detected
                if ($isPositional) {
                    $paramMap[$count] = $i;
                } else {
                    $name = "";
                    // TODO: Something faster/better to match this than regex?
                    for ($j = $i + 1; ($j < $stmtLen && preg_match('(([a-zA-Z0-9_]{1}))', $statement[$j])); $j++) {
                        $name .= $statement[$j];
                    }
                    $paramMap[$i] = $name; // named parameters can be duplicated!
                    $i = $j;
                }
                ++$count;
            } else if ($statement[$i] == "'" || $statement[$i] == '"') {
                $inLiteral = ! $inLiteral; // switch state!
            }
        }

        return $paramMap;
    }

    /**
     * For a positional query this method can rewrite the sql statement with regard to array parameters.
     *
     * @param string    $query  The SQL query to execute.
     * @param array     $params The parameters to bind to the query.
     * @param array     $types  The types the previous parameters are in.
     * 
     * @return array
     */
    static public function expandListParameters($query, $params, $types)
    {
        $isPositional   = is_int(key($params));
        $arrayPositions = array();
        $bindIndex      = -1;

        foreach ($types as $name => $type) {
            ++$bindIndex;

            if ($type !== Connection::PARAM_INT_ARRAY && $type !== Connection::PARAM_STR_ARRAY) {
                continue;
            }

            if ($isPositional) {
                $name = $bindIndex;
            }

            $arrayPositions[$name] = false;
        }

        if (( ! $arrayPositions && $isPositional) || (count($params) != count($types))) {
            return array($query, $params, $types);
        }

        $paramPos = self::getPlaceholderPositions($query, $isPositional);

        if ($isPositional) {
            $paramOffset = 0;
            $queryOffset = 0;

            foreach ($paramPos as $needle => $needlePos) {
                if ( ! isset($arrayPositions[$needle])) {
                    continue;
                }

                $needle    += $paramOffset;
                $needlePos += $queryOffset;
                $count      = count($params[$needle]);

                $params = array_merge(
                    array_slice($params, 0, $needle),
                    $params[$needle],
                    array_slice($params, $needle + 1)
                );

                $types = array_merge(
                    array_slice($types, 0, $needle),
                    array_fill(0, $count, $types[$needle] - Connection::ARRAY_PARAM_OFFSET), // array needles are at PDO::PARAM_* + 100
                    array_slice($types, $needle + 1)
                );

                $expandStr  = implode(", ", array_fill(0, $count, "?"));
                $query      = substr($query, 0, $needlePos) . $expandStr . substr($query, $needlePos + 1);

                $paramOffset += ($count - 1); // Grows larger by number of parameters minus the replaced needle.
                $queryOffset += (strlen($expandStr) - 1);
            }

            return array($query, $params, $types);
        }


        $queryOffset = 0;
        $typesOrd    = array();
        $paramsOrd   = array();

        foreach ($paramPos as $pos => $paramName) {
            $paramLen   = strlen($paramName) + 1;
            $value      = $params[$paramName];

            if ( ! isset($arrayPositions[$paramName])) {
                $pos         += $queryOffset;
                $queryOffset -= ($paramLen - 1);
                $paramsOrd[]  = $value;
                $typesOrd[]   = $types[$paramName];
                $query        = substr($query, 0, $pos) . '?' . substr($query, ($pos + $paramLen));
            
                continue;
            }

            $count      = count($value);
            $expandStr  = $count > 0 ? implode(', ', array_fill(0, $count, '?')) : '?';

            foreach ($value as $val) {
                $paramsOrd[] = $val;
                $typesOrd[]  = $types[$paramName] - Connection::ARRAY_PARAM_OFFSET;
            }

            $pos         += $queryOffset;
            $queryOffset += (strlen($expandStr) - $paramLen);
            $query        = substr($query, 0, $pos) . $expandStr . substr($query, ($pos + $paramLen));
        }

        return array($query, $paramsOrd, $typesOrd);
    }
}
