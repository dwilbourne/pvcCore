<?php declare(strict_types = 1);

namespace pvc\charset;

/**
 * Charset tries to provide canonicalization of a wide range of IANA registered charsets.
 *
 * Class Charset
 */
class Charset
{

    // default charset is utf-8
    public const DEFAULT_CHARSET = 119;

    // These are done more or less by language
    public const ARABIC_ASMO_708 = 1;
    public const ARABIC_DOS = 2;
    public const ARABIC_ISO = 3;
    public const ARABIC_MAC = 4;
    public const ARABIC_WINDOWS = 5;
    public const BALTIC_DOS = 6;
    public const BALTIC_ISO = 7;
    public const BALTIC_WINDOWS = 8;
    public const CENTRAL_EUROPEAN_DOS = 9;
    public const CENTRAL_EUROPEAN_ISO = 10;
    public const CENTRAL_EUROPEAN_MAC = 11;
    public const CENTRAL_EUROPEAN_WINDOWS = 12;
    public const CHINESE_SIMPLIFIED_EUC = 13;
    public const CHINESE_SIMPLIFIED_GB2312 = 14;
    public const CHINESE_SIMPLIFIED_HZ = 15;
    public const CHINESE_SIMPLIFIED_MAC = 16;
    public const CHINESE_TRADITIONAL_BIG5 = 17;
    public const CHINESE_TRADITIONAL_CNS = 18;
    public const CHINESE_TRADITIONAL_ETEN = 19;
    public const CHINESE_TRADITIONAL_MAC = 20;
    public const CYRILLIC_DOS = 21;
    public const CYRILLIC_ISO = 22;
    public const CYRILLIC_KOI8_R = 23;
    public const CYRILLIC_KOI8_U = 24;
    public const CYRILLIC_MAC = 25;
    public const CYRILLIC_WINDOWS = 26;
    public const EUROPA = 27;
    public const GERMAN_IA5 = 28;
    public const GREEK_DOS = 29;
    public const GREEK_ISO = 30;
    public const GREEK_MAC = 31;
    public const GREEK_WINDOWS = 32;
    public const GREEK_MODERN_DOS = 33;
    public const HEBREW_DOS = 34;
    public const HEBREW_ISO_LOGICAL = 35;
    public const HEBREW_ISO_VISUAL = 36;
    public const HEBREW_MAC = 37;
    public const HEBREW_WINDOWS = 38;
    public const IBM_EBCDIC_ARABIC = 39;
    public const IBM_EBCDIC_CYRILLIC_RUSSIAN = 40;
    public const IBM_EBCDIC_CYRILLIC_SERBIAN_BULGARIAN = 41;
    public const IBM_EBCDIC_DENMARK_NORWAY = 42;
    public const IBM_EBCDIC_DENMARK_NORWAY_EURO = 43;
    public const IBM_EBCDIC_FINLAND_SWEDEN = 44;
    public const IBM_EBCDIC_FINLAND_SWEDEN_EURO = 45;
    public const IBM_EBCDIC_FRANCE_EURO = 46;
    public const IBM_EBCDIC_GERMANY = 47;
    public const IBM_EBCDIC_GERMANY_EURO = 48;
    public const IBM_EBCDIC_GREEK_MODERN = 49;
    public const IBM_EBCDIC_GREEK = 50;
    public const IBM_EBCDIC_HEBREW = 51;
    public const IBM_EBCDIC_ICELANDIC = 52;
    public const IBM_EBCDIC_ICELANDIC_EURO = 53;
    public const IBM_EBCDIC_INTERNATIONAL_EURO = 54;
    public const IBM_EBCDIC_ITALY = 55;
    public const IBM_EBCDIC_ITALY_EURO = 56;
    public const IBM_EBCDIC_JAPANESE_AND_JAPANESE_KATAKANA = 57;
    public const IBM_EBCDIC_JAPANESE_AND_JAPANESE_LATIN = 58;
    public const IBM_EBCDIC_JAPANESE_AND_US_CANADA = 59;
    public const IBM_EBCDIC_JAPANESE_KATAKANA = 60;
    public const IBM_EBCDIC_KOREAN_AND_KOREAN_EXTENDED = 61;
    public const IBM_EBCDIC_KOREAN_EXTENDED = 62;
    public const IBM_EBCDIC_MULTILINGUAL_LATIN_2 = 63;
    public const IBM_EBCDIC_SIMPLIFIED_CHINESE = 64;
    public const IBM_EBCDIC_SPAIN = 65;
    public const IBM_EBCDIC_SPAIN_EURO = 66;
    public const IBM_EBCDIC_THAI = 67;
    public const IBM_EBCDIC_TRADITIONAL_CHINESE = 68;
    public const IBM_EBCDIC_TURKISH_LATIN_5 = 69;
    public const IBM_EBCDIC_TURKISH = 70;
    public const IBM_EBCDIC_UK = 71;
    public const IBM_EBCDIC_UK_EURO = 72;
    public const IBM_EBCDIC_US_CANADA = 73;
    public const IBM_EBCDIC_US_CANADA_EURO = 74;
    public const ICELANDIC_DOS = 75;
    public const ICELANDIC_MAC = 76;
    public const ISCII_ASSAMESE = 77;
    public const ISCII_BENGALI = 78;
    public const ISCII_DEVANAGARI = 79;
    public const ISCII_GUJARATHI = 80;
    public const ISCII_KANNADA = 81;
    public const ISCII_MALAYALAM = 82;
    public const ISCII_ORIYA = 83;
    public const ISCII_PANJABI = 84;
    public const ISCII_TAMIL = 85;
    public const ISCII_TELUGU = 86;
    public const JAPANESE_EUC = 87;
    public const JAPANESE_JIS = 88;
    public const JAPANESE_JIS_ALLOW_1_BYTE_KANA_SO_SI = 89;
    public const JAPANESE_JIS_ALLOW_1_BYTE_KANA = 90;
    public const JAPANESE_MAC = 91;
    public const JAPANESE_SHIFT_JIS = 92;
    public const KOREAN = 93;
    public const KOREAN_EUC = 94;
    public const KOREAN_ISO = 95;
    public const KOREAN_JOHAB = 96;
    public const KOREAN_MAC = 97;
    public const LATIN_3_ISO = 98;
    public const LATIN_9_ISO = 99;
    public const NORWEGIAN_IA5 = 100;
    public const OEM_UNITED_STATES = 101;
    public const SWEDISH_IA5 = 102;
    public const THAI_WINDOWS = 103;
    public const TURKISH_DOS = 104;
    public const TURKISH_ISO = 105;
    public const TURKISH_MAC = 106;
    public const TURKISH_WINDOWS = 107;
    public const UNICODE = 108;
    public const UNICODE_BIG_ENDIAN = 109;
    public const UNICODE_UTF_7 = 110;
    // a duplicate of UTF_8
    // public const UNICODE_UTF_8 = 111;
    public const US_ASCII = 112;
    public const VIETNAMESE_WINDOWS = 113;
    public const WESTERN_EUROPEAN_DOS = 114;
    public const WESTERN_EUROPEAN_IA5 = 115;
    public const WESTERN_EUROPEAN_ISO = 116;
    public const WESTERN_EUROPEAN_MAC = 117;
    public const WESTERN_EUROPEAN_WINDOWS = 118;

    // these are more typical in the web world
    public const UTF_8 = 119;
    public const UTF_16 = 120;
    public const WINDOWS_1250 = 121;
    public const WINDOWS_1251 = 122;
    public const WINDOWS_1252 = 123;
    public const WINDOWS_1253 = 124;
    public const WINDOWS_1254 = 125;
    public const WINDOWS_1255 = 126;
    public const WINDOWS_1256 = 127;
    public const WINDOWS_1257 = 128;
    public const WINDOWS_1258 = 129;
    public const ISO_8859_1 = 130;
    public const ISO_8859_2 = 131;
    public const ISO_8859_3 = 132;
    public const ISO_8859_4 = 133;
    public const ISO_8859_5 = 134;
    public const ISO_8859_6 = 135;
    public const ISO_8859_7 = 136;
    public const ISO_8859_8 = 137;
    public const ISO_8859_9 = 138;
    public const ISO_8859_13 = 139;
    public const ISO_8859_15 = 140;
    public const KOI8_R = 141;
    public const TIS_620 = 142;
    public const GBK = 143;
    public const GB18030 = 144;
    public const BIG5 = 145;
    public const BIG5_HKSCS = 146;
    public const SHIFT_JIS = 147;
    public const ISO_2022_JP = 148;
    public const EUC_JP = 149;
    public const ISO_2022_KR = 150;
    public const EUC_KR = 151;

    protected array $validCharsets =
        [
            // The language oriented constants
            self::ARABIC_ASMO_708 => 'ASMO-708',
            self::ARABIC_DOS => 'DOS-720',
            self::ARABIC_ISO => 'iso-8859-6',
            self::ARABIC_MAC => 'x-mac-arabic',
            self::ARABIC_WINDOWS => 'windows-1256',
            self::BALTIC_DOS => 'ibm775',
            self::BALTIC_ISO => 'iso-8859-4',
            self::BALTIC_WINDOWS => 'windows-1257',
            self::CENTRAL_EUROPEAN_DOS => 'ibm852',
            self::CENTRAL_EUROPEAN_ISO => 'iso-8859-2',
            self::CENTRAL_EUROPEAN_MAC => 'x-mac-ce',
            self::CENTRAL_EUROPEAN_WINDOWS => 'windows-1250',
            self::CHINESE_SIMPLIFIED_EUC => 'EUC-CN',
            self::CHINESE_SIMPLIFIED_GB2312 => 'gb2312',
            self::CHINESE_SIMPLIFIED_HZ => 'hz-gb-2312',
            self::CHINESE_SIMPLIFIED_MAC => 'x-mac-chinesesimp',
            self::CHINESE_TRADITIONAL_BIG5 => 'big5',
            self::CHINESE_TRADITIONAL_CNS => 'x-Chinese-CNS',
            self::CHINESE_TRADITIONAL_ETEN => 'x-Chinese-Eten',
            self::CHINESE_TRADITIONAL_MAC => 'x-mac-chinesetrad - 950',
            self::CYRILLIC_DOS => 'cp866',
            self::CYRILLIC_ISO => 'iso-8859-5',
            self::CYRILLIC_KOI8_R => 'koi8-r',
            self::CYRILLIC_KOI8_U => 'koi8-u',
            self::CYRILLIC_MAC => 'x-mac-cyrillic',
            self::CYRILLIC_WINDOWS => 'windows-1251',
            self::EUROPA => 'x-Europa',
            self::GERMAN_IA5 => 'x-IA5-German',
            self::GREEK_DOS => 'ibm737',
            self::GREEK_ISO => 'iso-8859-7',
            self::GREEK_MAC => 'x-mac-greek',
            self::GREEK_WINDOWS => 'windows-1253',
            self::GREEK_MODERN_DOS => 'ibm869',
            self::HEBREW_DOS => 'DOS-862',
            self::HEBREW_ISO_LOGICAL => 'iso-8859-8-i',
            self::HEBREW_ISO_VISUAL => 'iso-8859-8',
            self::HEBREW_MAC => 'x-mac-hebrew',
            self::HEBREW_WINDOWS => 'windows-1255',
            self::IBM_EBCDIC_ARABIC => 'x-EBCDIC-Arabic',
            self::IBM_EBCDIC_CYRILLIC_RUSSIAN => 'x-EBCDIC-CyrillicRussian',
            self::IBM_EBCDIC_CYRILLIC_SERBIAN_BULGARIAN => 'x-EBCDIC-CyrillicSerbianBulgarian',
            self::IBM_EBCDIC_DENMARK_NORWAY => 'x-EBCDIC-DenmarkNorway',
            self::IBM_EBCDIC_DENMARK_NORWAY_EURO => 'x-ebcdic-denmarknorway-euro',
            self::IBM_EBCDIC_FINLAND_SWEDEN => 'x-EBCDIC-FinlandSweden',
            self::IBM_EBCDIC_FINLAND_SWEDEN_EURO => 'x-ebcdic-finlandsweden-euro',
            self::IBM_EBCDIC_FRANCE_EURO => 'x-ebcdic-france-euro',
            self::IBM_EBCDIC_GERMANY => 'x-EBCDIC-Germany',
            self::IBM_EBCDIC_GERMANY_EURO => 'x-ebcdic-germany-euro',
            self::IBM_EBCDIC_GREEK_MODERN => 'x-EBCDIC-GreekModern',
            self::IBM_EBCDIC_GREEK => 'x-EBCDIC-Greek',
            self::IBM_EBCDIC_HEBREW => 'x-EBCDIC-Hebrew',
            self::IBM_EBCDIC_ICELANDIC => 'x-EBCDIC-Icelandic',
            self::IBM_EBCDIC_ICELANDIC_EURO => 'x-ebcdic-icelandic-euro',
            self::IBM_EBCDIC_INTERNATIONAL_EURO => 'x-ebcdic-international-euro',
            self::IBM_EBCDIC_ITALY => 'x-EBCDIC-Italy',
            self::IBM_EBCDIC_ITALY_EURO => 'x-ebcdic-italy-euro',
            self::IBM_EBCDIC_JAPANESE_AND_JAPANESE_KATAKANA => 'x-EBCDIC-JapaneseAndKana',
            self::IBM_EBCDIC_JAPANESE_AND_JAPANESE_LATIN => 'x-EBCDIC-JapaneseAndJapaneseLatin',
            self::IBM_EBCDIC_JAPANESE_AND_US_CANADA => 'x-EBCDIC-JapaneseAndUSCanada',
            self::IBM_EBCDIC_JAPANESE_KATAKANA => 'x-EBCDIC-JapaneseKatakana',
            self::IBM_EBCDIC_KOREAN_AND_KOREAN_EXTENDED => 'x-EBCDIC-KoreanAndKoreanExtended',
            self::IBM_EBCDIC_KOREAN_EXTENDED => 'x-EBCDIC-KoreanExtended',
            self::IBM_EBCDIC_MULTILINGUAL_LATIN_2 => 'CP870',
            self::IBM_EBCDIC_SIMPLIFIED_CHINESE => 'x-EBCDIC-SimplifiedChinese',
            self::IBM_EBCDIC_SPAIN => 'X-EBCDIC-Spain',
            self::IBM_EBCDIC_SPAIN_EURO => 'x-ebcdic-spain-euro',
            self::IBM_EBCDIC_THAI => 'x-EBCDIC-Thai',
            self::IBM_EBCDIC_TRADITIONAL_CHINESE => 'x-EBCDIC-TraditionalChinese',
            self::IBM_EBCDIC_TURKISH_LATIN_5 => 'CP1026',
            self::IBM_EBCDIC_TURKISH => 'x-EBCDIC-Turkish',
            self::IBM_EBCDIC_UK => 'x-EBCDIC-UK',
            self::IBM_EBCDIC_UK_EURO => 'x-ebcdic-uk-euro',
            self::IBM_EBCDIC_US_CANADA => 'ebcdic-cp-us',
            self::IBM_EBCDIC_US_CANADA_EURO => 'x-ebcdic-cp-us-euro',
            self::ICELANDIC_DOS => 'ibm861',
            self::ICELANDIC_MAC => 'x-mac-icelandic',
            self::ISCII_ASSAMESE => 'x-iscii-as',
            self::ISCII_BENGALI => 'x-iscii-be',
            self::ISCII_DEVANAGARI => 'x-iscii-de',
            self::ISCII_GUJARATHI => 'x-iscii-gu',
            self::ISCII_KANNADA => 'x-iscii-ka',
            self::ISCII_MALAYALAM => 'x-iscii-ma',
            self::ISCII_ORIYA => 'x-iscii-or',
            self::ISCII_PANJABI => 'x-iscii-pa',
            self::ISCII_TAMIL => 'x-iscii-ta',
            self::ISCII_TELUGU => 'x-iscii-te',
            self::JAPANESE_EUC => 'euc-jp - x-euc-jp',
            self::JAPANESE_JIS => 'iso-2022-jp',
            self::JAPANESE_JIS_ALLOW_1_BYTE_KANA_SO_SI => 'iso-2022-jp',
            self::JAPANESE_JIS_ALLOW_1_BYTE_KANA => 'csISO2022JP',
            self::JAPANESE_MAC => 'x-mac-japanese',
            self::JAPANESE_SHIFT_JIS => 'shift_jis',
            self::KOREAN => 'ks_c_5601-1987',
            self::KOREAN_EUC => 'euc-kr',
            self::KOREAN_ISO => 'iso-2022-kr',
            self::KOREAN_JOHAB => 'Johab',
            self::KOREAN_MAC => 'x-mac-korean',
            self::LATIN_3_ISO => 'iso-8859-3',
            self::LATIN_9_ISO => 'iso-8859-15',
            self::NORWEGIAN_IA5 => 'x-IA5-Norwegian',
            self::OEM_UNITED_STATES => 'IBM437',
            self::SWEDISH_IA5 => 'x-IA5-Swedish',
            self::THAI_WINDOWS => 'windows-874',
            self::TURKISH_DOS => 'ibm857',
            self::TURKISH_ISO => 'iso-8859-9',
            self::TURKISH_MAC => 'x-mac-turkish',
            self::TURKISH_WINDOWS => 'windows-1254',
            self::UNICODE => 'unicode',
            self::UNICODE_BIG_ENDIAN => 'unicodeFFFE',
            self::UNICODE_UTF_7 => 'utf-7',
            // a duplicate
            // self::UNICODE_UTF_8 => 'utf-8',
            self::US_ASCII => 'us-ascii',
            self::VIETNAMESE_WINDOWS => 'windows-1258',
            self::WESTERN_EUROPEAN_DOS => 'ibm850',
            self::WESTERN_EUROPEAN_IA5 => 'x-IA5',
            self::WESTERN_EUROPEAN_ISO => 'iso-8859-1',
            self::WESTERN_EUROPEAN_MAC => 'macintosh',
            self::WESTERN_EUROPEAN_WINDOWS => 'Windows-1252',

            // the more typical references
            self::UTF_8 => 'UTF-8',
            self::UTF_16 => 'UTF-16',
            self::WINDOWS_1250 => 'Windows-1250',
            self::WINDOWS_1251 => 'Windows-1251',
            self::WINDOWS_1252 => 'Windows-1252',
            self::WINDOWS_1253 => 'Windows-1253',
            self::WINDOWS_1254 => 'Windows-1254',
            self::WINDOWS_1255 => 'Windows-1255',
            self::WINDOWS_1256 => 'Windows-1256',
            self::WINDOWS_1257 => 'Windows-1257',
            self::WINDOWS_1258 => 'Windows-1258',
            self::ISO_8859_1 => 'ISO-8859-1',
            self::ISO_8859_2 => 'ISO-8859-2',
            self::ISO_8859_3 => 'ISO-8859-3',
            self::ISO_8859_4 => 'ISO-8859-4',
            self::ISO_8859_5 => 'ISO-8859-5',
            self::ISO_8859_6 => 'ISO-8859-6',
            self::ISO_8859_7 => 'ISO-8859-7',
            self::ISO_8859_8 => 'ISO-8859-8',
            self::ISO_8859_9 => 'ISO-8859-9',
            self::ISO_8859_13 => 'ISO-8859-13',
            self::ISO_8859_15 => 'ISO-8859-15',
            self::KOI8_R => 'KOI8-R',
            self::TIS_620 => 'TIS-620',
            self::GBK => 'GBK',
            self::GB18030 => 'GB18030',
            self::BIG5 => 'Big5',
            self::BIG5_HKSCS => 'Big5-HKSCS',
            self::SHIFT_JIS => 'Shift_JIS',
            self::ISO_2022_JP => 'ISO-2022-JP',
            self::EUC_JP => 'EUC-JP',
            self::ISO_2022_KR => 'ISO-2022-KR',
            self::EUC_KR => 'EUC-KR',
        ];

    /**
     * holds the charset constant
     *
     * @var int
     */
    protected int $charset;

    /**
     * Charset constructor.
     * @param int $charset
     * @throws InvalidCharsetException
     */
    public function __construct(int $charset = self::DEFAULT_CHARSET)
    {
        $this->setCharset($charset);
    }

    /**
     * @function setCharset
     * @param int $charset
     * @throws InvalidCharsetException
     */
    public function setCharset(int $charset): void
    {
        if (isset($this->validCharsets[$charset])) {
            $this->charset = $charset;
        } else {
            throw new InvalidCharsetException($charset);
        }
    }

    /**
     * @function __toString
     * @return string
     */
    public function __toString(): string
    {
        return $this->getCharsetString();
    }

    /**
     * @function getCharsetString
     * @return string
     */
    public function getCharsetString(): string
    {
        return $this->validCharsets[$this->charset];
    }

    /**
     * @function getCharsetConstant
     * @return int
     */
    public function getCharsetConstant(): int
    {
        return $this->charset;
    }

    /**
     * @function getValidCharsets
     * @return array|string[]
     */
    public function getValidCharsets(): array
    {
        return $this->validCharsets;
    }

    /**
     * @function parseCharsetString
     * @param string $charset
     * @return bool
     */
    public function parseCharsetString(string $charset): bool
    {
        $key = array_search(strtolower($charset), array_map('strtolower', $this->validCharsets));
        if ($key === false) {
            return false;
        } else {
            $this->charset = (int) $key;
            return true;
        }
    }
}
