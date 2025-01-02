import MonkeyIconBlack from '../../../public/images/board/animals/icon-36.png';
import MonkeyIconWhite from '../../../public/images/board/animals/icon-44.png';
import CatIconBlack from '../../../public/images/board/animals/icon-59.png';
import CatIconWhite from '../../../public/images/board/animals/icon-60.png';
import NikeIconWhite from '../../images/extra_objects/nike.png';
import NikeIconBlack from '../../images/extra_objects/nike_black.png';
import AdidasIconWhite from '../../images/extra_objects/adidas_white.png';
import AdidasIconBlack from '../../images/extra_objects/adidas.png';
import WBIcon from '../../images/extra_objects/wb.png';
import PepsiIconWhite from '../../images/extra_objects/pepsi.png';
import PepsiIconBlack from '../../images/extra_objects/pepsi_black.png';
import LacosteIconWhite from '../../images/extra_objects/coco_white.png';
import LacosteIconBlack from '../../images/extra_objects/coco.png';
import LandIconWhite from '../../images/extra_objects/palm.png';
import LandIconBlack from '../../images/extra_objects/palm_black.png';
import SandboxIconWhite from '../../images/extra_objects/mario.png';
import SandboxIconBlack from '../../images/extra_objects/mario_black.png';
import tigerIconBlack from '../../../public/images/board/animals/icon-38.png'
import tigerIconWhite from '../../../public/images/board/animals/icon-46.png'
import leopardIconBlack from '../../../public/images/board/animals/icon-37.png'
import leopardIconWhite from '../../../public/images/board/animals/icon-45.png'
import LionIconBlack from '../../../public/images/board/animals/icon-39.png';
import LionIconWhite from '../../../public/images/board/animals/icon-47.png';
import BotIconWhite from '../../images/extra_objects/bot.png';
import BotIconBlack from '../../images/extra_objects/bot_black.png';
import RaygunIconWhite from '../../images/extra_objects/raygun.png';
import RaygunIconBlack from '../../images/extra_objects/raygun_black.png';
import DoodleIconWhite from '../../images/extra_objects/8.png';
import DoodleIconBlack from '../../images/extra_objects/8_black.png';
import TotemIconWhite from '../../images/extra_objects/ghost.png';
import TotemIconBlack from '../../images/extra_objects/ghost_black.png';
export default function colorIconNft(colorIcon){
    return {
        nft_1_sunflower_1: '',
        nft_2_jungle_mega: '',
        nft_2_jungle_1: '',
        nft_2_jungle_1_base: '',
        nft_2_jungle_1_polygon: '',
        nft_3_battery:{
            type: 'icon',
            class: 'fa-solid fa-battery-full',
            size: '24px'
        },
        nft_4_color1: '',
        nft_5_color2: '',
        nft_6_color3: '',
        nft_7_color4: '',
        nft_8_bot: (colorIcon === 3 || colorIcon === 5) ? BotIconWhite : BotIconBlack,
        nft_21_raygun: (colorIcon === 3 || colorIcon === 5) ? RaygunIconWhite : RaygunIconBlack,
        nft_9_cat: (colorIcon === 3 || colorIcon === 5) ? CatIconWhite : CatIconBlack,
        nft_10_monkey: {
            image : (colorIcon === 3 || colorIcon === 5) ? MonkeyIconWhite : MonkeyIconBlack,
            size: '35px',
        },
        nft_11_punks: {
            type: 'icon',
            class: 'fa-solid fa-hand-fist',
            size: '20px'
        },
        nft_12_monster: {
            type: 'icon',
            class: 'fa-solid fa-egg',
            size: '20px'
        },
        nft_13_doodle: {
            image : (colorIcon === 3 || colorIcon === 5) ? DoodleIconWhite : DoodleIconBlack,
            size: '20px',
        },
        nft_14_sandbox: {
            image : (colorIcon === 3 || colorIcon === 5) ? SandboxIconWhite : SandboxIconBlack,
            size: '20px',
        },
        nft_15_totem: {
            image : (colorIcon === 3 || colorIcon === 5) ? TotemIconWhite : TotemIconBlack,
            size: '20px',
        },
        nft_16_nike: {
            image : (colorIcon === 3 || colorIcon === 5) ? NikeIconWhite : NikeIconBlack,
            size: '25px',
        },
        nft_17_adidas: {
            image : (colorIcon === 3 || colorIcon === 5) ? AdidasIconWhite : AdidasIconBlack,
            size: '25px',
        },
        nft_18_pepsi: {
            image : (colorIcon === 3 || colorIcon === 5) ? PepsiIconWhite : PepsiIconBlack,
            size: '20px',
        },
        nft_19_lacoste: {
            image : (colorIcon === 3 || colorIcon === 5) ? LacosteIconWhite : LacosteIconBlack,
            size: '30px',
        },
        nft_20_land: {
            image : (colorIcon === 3 || colorIcon === 5) ? LandIconWhite : LandIconBlack,
            size: '18px',
        },
        nft_22_leo_1: (colorIcon === 3 || colorIcon === 5) ? leopardIconWhite : leopardIconBlack,
        nft_23_leo_2: (colorIcon === 3 || colorIcon === 5) ? tigerIconWhite : tigerIconBlack,
        nft_24_leo_3: (colorIcon === 3 || colorIcon === 5) ? LionIconWhite : LionIconBlack,
        nft_25_wb: WBIcon,
    };
}
