<?php declare(strict_types = 1);

namespace pvc\validator\sys;

use pvc\msg\Msg;
use pvc\msg\MsgInterface;
use pvc\validator\base\data_type\ValidatorTypeText;
use pvc\validator\base\min_max\ValidatorMinMaxText;
use pvc\validator\base\text\regex\ValidatorRegexWindowsFilename;
use pvc\validator\base\Validator;
use pvc\validator\base\ValidatorInterface;

/**
 * Class ValidatorFilenameWindows
 */
class ValidatorFilenameWindows extends Validator implements ValidatorInterface
{
    /**
     * ValidatorFilenameWindows constructor.
     * @param bool $allowFileExtension
     * @param bool $required
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidTypeException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\InvalidValueException
     * @throws \pvc\err\throwable\exception\pvc_exceptions\UnsetAttributeException
     */
    public function __construct(bool $allowFileExtension = true, $required = true)
    {
        $vt = new ValidatorTypeText();
        parent::__construct($vt, $required);

        // newer versions of Windows might allow filenames > 256 chars but let's be real here....
        $validatorText = new ValidatorMinMaxText(1, 256);
        $this->push($validatorText);

        $validatorRegex = new ValidatorRegexWindowsFilename($allowFileExtension);
        $this->push($validatorRegex);
    }
}
