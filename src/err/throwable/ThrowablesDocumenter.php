<?php declare(strict_types = 1);

namespace pvc\err\throwable;

use pvc\err\throwable\exception\stock_rebrands\InvalidArgumentException;
use pvc\filesys\FindFile;
use pvc\parser\file\php\ParserClassNode;
use pvc\regex\Regex;

/**
 * ThrowablesDocumenter creates a list of all the throwables in the given search directory.
 *
 * Class ThrowablesDocumenter
 */
class ThrowablesDocumenter
{

    /**
     * @function generateThrowables
     * @param string $searchDir
     * @return array
     * @throws InvalidArgumentException
     * @throws \pvc\filesys\err\FilesysBadSearchDirException
     * @throws \pvc\regex\err\RegexBadPatternException
     */
    public function generateThrowables(string $searchDir): array
    {
        $regex = new Regex();
        $regex->setPattern('/^(.*\.php)$/iU');
        $findFile = new FindFile([$regex, 'match']);

        $fileArray = $findFile->findFiles($searchDir);
        $parser = new ParserClassNode();

        $result = [];

        foreach ($fileArray as $file) {
            if ($classNode = $parser->parse($file)) {
                $className = (string) $classNode->namespacedName;
            }

            if (isset($className) && (in_array('Throwable', class_implements($className)))) {
                $result[$className] = $file;
            }
        }
        return $result;
    }
}
