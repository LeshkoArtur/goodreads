<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BookLanguage: string implements HasColor, HasIcon, HasLabel
{
    case AA = 'aa'; // Afar
    case AB = 'ab'; // Abkhazian
    case AF = 'af'; // Afrikaans
    case AK = 'ak'; // Akan
    case AM = 'am'; // Amharic
    case AN = 'an'; // Aragonese
    case AR = 'ar'; // Arabic
    case AS = 'as'; // Assamese
    case AV = 'av'; // Avaric
    case AY = 'ay'; // Aymara
    case AZ = 'az'; // Azerbaijani
    case BA = 'ba'; // Bashkir
    case BE = 'be'; // Belarusian
    case BG = 'bg'; // Bulgarian
    case BH = 'bh'; // Bihari
    case BI = 'bi'; // Bislama
    case BM = 'bm'; // Bambara
    case BN = 'bn'; // Bengali
    case BO = 'bo'; // Tibetan
    case BR = 'br'; // Breton
    case BS = 'bs'; // Bosnian
    case CA = 'ca'; // Catalan
    case CE = 'ce'; // Chechen
    case CH = 'ch'; // Chamorro
    case CO = 'co'; // Corsican
    case CR = 'cr'; // Cree
    case CS = 'cs'; // Czech
    case CU = 'cu'; // Church Slavic
    case CV = 'cv'; // Chuvash
    case CY = 'cy'; // Welsh
    case DA = 'da'; // Danish
    case DE = 'de'; // German
    case DV = 'dv'; // Divehi
    case DZ = 'dz'; // Dzongkha
    case EE = 'ee'; // Ewe
    case EL = 'el'; // Greek
    case EN = 'en'; // English
    case EO = 'eo'; // Esperanto
    case ES = 'es'; // Spanish
    case ET = 'et'; // Estonian
    case EU = 'eu'; // Basque
    case FA = 'fa'; // Persian
    case FF = 'ff'; // Fulah
    case FI = 'fi'; // Finnish
    case FJ = 'fj'; // Fijian
    case FO = 'fo'; // Faroese
    case FR = 'fr'; // French
    case FY = 'fy'; // Western Frisian
    case GA = 'ga'; // Irish
    case GD = 'gd'; // Scottish Gaelic
    case GL = 'gl'; // Galician
    case GN = 'gn'; // Guarani
    case GU = 'gu'; // Gujarati
    case GV = 'gv'; // Manx
    case HA = 'ha'; // Hausa
    case HE = 'he'; // Hebrew
    case HI = 'hi'; // Hindi
    case HO = 'ho'; // Hiri Motu
    case HR = 'hr'; // Croatian
    case HT = 'ht'; // Haitian Creole
    case HU = 'hu'; // Hungarian
    case HY = 'hy'; // Armenian
    case HZ = 'hz'; // Herero
    case IA = 'ia'; // Interlingua
    case ID = 'id'; // Indonesian
    case IE = 'ie'; // Interlingue
    case IG = 'ig'; // Igbo
    case II = 'ii'; // Sichuan Yi
    case IK = 'ik'; // Inupiaq
    case IO = 'io'; // Ido
    case IS = 'is'; // Icelandic
    case IT = 'it'; // Italian
    case IU = 'iu'; // Inuktitut
    case JA = 'ja'; // Japanese
    case JV = 'jv'; // Javanese
    case KA = 'ka'; // Georgian
    case KG = 'kg'; // Kongo
    case KI = 'ki'; // Kikuyu
    case KJ = 'kj'; // Kuanyama
    case KK = 'kk'; // Kazakh
    case KL = 'kl'; // Kalaallisut
    case KM = 'km'; // Khmer
    case KN = 'kn'; // Kannada
    case KO = 'ko'; // Korean
    case KR = 'kr'; // Kanuri
    case KS = 'ks'; // Kashmiri
    case KU = 'ku'; // Kurdish
    case KV = 'kv'; // Komi
    case KW = 'kw'; // Cornish
    case KY = 'ky'; // Kyrgyz
    case LA = 'la'; // Latin
    case LB = 'lb'; // Luxembourgish
    case LG = 'lg'; // Ganda
    case LI = 'li'; // Limburgish
    case LN = 'ln'; // Lingala
    case LO = 'lo'; // Lao
    case LT = 'lt'; // Lithuanian
    case LU = 'lu'; // Luba-Katanga
    case LV = 'lv'; // Latvian
    case MG = 'mg'; // Malagasy
    case MH = 'mh'; // Marshallese
    case MI = 'mi'; // Maori
    case MK = 'mk'; // Macedonian
    case ML = 'ml'; // Malayalam
    case MN = 'mn'; // Mongolian
    case MR = 'mr'; // Marathi
    case MS = 'ms'; // Malay
    case MT = 'mt'; // Maltese
    case MY = 'my'; // Burmese
    case NA = 'na'; // Nauru
    case NB = 'nb'; // Norwegian Bokmål
    case ND = 'nd'; // North Ndebele
    case NE = 'ne'; // Nepali
    case NG = 'ng'; // Ndonga
    case NL = 'nl'; // Dutch
    case NN = 'nn'; // Norwegian Nynorsk
    case NO = 'no'; // Norwegian
    case NR = 'nr'; // South Ndebele
    case NV = 'nv'; // Navajo
    case NY = 'ny'; // Chichewa
    case OC = 'oc'; // Occitan
    case OJ = 'oj'; // Ojibwa
    case OM = 'om'; // Oromo
    case OR = 'or'; // Odia
    case OS = 'os'; // Ossetian
    case PA = 'pa'; // Punjabi
    case PI = 'pi'; // Pali
    case PL = 'pl'; // Polish
    case PS = 'ps'; // Pashto
    case PT = 'pt'; // Portuguese
    case QU = 'qu'; // Quechua
    case RM = 'rm'; // Romansh
    case RN = 'rn'; // Kirundi
    case RO = 'ro'; // Romanian
    case RU = 'ru'; // Russian
    case RW = 'rw'; // Kinyarwanda
    case SA = 'sa'; // Sanskrit
    case SC = 'sc'; // Sardinian
    case SD = 'sd'; // Sindhi
    case SE = 'se'; // Northern Sami
    case SG = 'sg'; // Sango
    case SI = 'si'; // Sinhala
    case SK = 'sk'; // Slovak
    case SL = 'sl'; // Slovenian
    case SM = 'sm'; // Samoan
    case SN = 'sn'; // Shona
    case SO = 'so'; // Somali
    case SQ = 'sq'; // Albanian
    case SR = 'sr'; // Serbian
    case SS = 'ss'; // Swati
    case ST = 'st'; // Southern Sotho
    case SU = 'su'; // Sundanese
    case SV = 'sv'; // Swedish
    case SW = 'sw'; // Swahili
    case TA = 'ta'; // Tamil
    case TE = 'te'; // Telugu
    case TG = 'tg'; // Tajik
    case TH = 'th'; // Thai
    case TI = 'ti'; // Tigrinya
    case TK = 'tk'; // Turkmen
    case TL = 'tl'; // Tagalog
    case TN = 'tn'; // Tswana
    case TO = 'to'; // Tongan
    case TR = 'tr'; // Turkish
    case TS = 'ts'; // Tsonga
    case TT = 'tt'; // Tatar
    case TW = 'tw'; // Twi
    case TY = 'ty'; // Tahitian
    case UG = 'ug'; // Uyghur
    case UK = 'uk'; // Ukrainian
    case UR = 'ur'; // Urdu
    case UZ = 'uz'; // Uzbek
    case VE = 've'; // Venda
    case VI = 'vi'; // Vietnamese
    case VO = 'vo'; // Volapük
    case WA = 'wa'; // Walloon
    case WO = 'wo'; // Wolof
    case XH = 'xh'; // Xhosa
    case YI = 'yi'; // Yiddish
    case YO = 'yo'; // Yoruba
    case ZA = 'za'; // Zhuang
    case ZH = 'zh'; // Chinese
    case ZU = 'zu'; // Zulu

    // Localized labels for Filament
    public function getLabel(): ?string
    {
        return __('book_language.'.$this->value);
    }

    // Colors for display in Filament
    public function getColor(): string|array|null
    {
        // Rotate through a set of colors to differentiate languages
        $colors = ['primary', 'success', 'info', 'warning', 'danger', 'gray'];
        $index = array_search($this->value, array_column(self::cases(), 'value')) % count($colors);

        return $colors[$index];
    }

    // Icons for Filament
    public function getIcon(): ?string
    {
        // Use a generic language icon for all languages
        return 'heroicon-o-globe-alt';
    }
}
