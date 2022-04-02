<?php

namespace Fu\Geo;

/**
 * 地点
 * 三级结构的地点数据
 * 分为两个可能：
 * 国内/省/市/区
 * 海外/洲/国家
 */
class Area
{
    /**
     * 国家/海外
     *
     * @var string
     */
    public string $nation = '';

    /**
     * 省/洲
     *
     * @var string
     */
    public string $lv1 = '';

    /**
     * 城市/海外国家
     *
     * @var string
     */
    public string $lv2 = '';

    /**
     * 区、县
     *
     * @var string
     */
    public string $lv3 = '';

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter(array_values(get_object_vars($this)), function ($item) {
            return !empty($item);
        });
    }

    /**
     * @return array|null
     */
    public function toJson(): ?array
    {
        return $this->nation ? get_object_vars($this) : null;
    }

    /**
     * 查询对应国家对应的大洲
     * @param string $nation
     * @return string
     */
    public static function getContinent(string $nation): string
    {
        $oversea = static::getOversea();
        return $oversea[$nation] ?? '';
    }

    /**
     * @return array
     */
    public static function getOversea(): array
    {
        return array(
            '日本'         => '亚洲',
            '朝鲜'         => '亚洲',
            '韩国'         => '亚洲',
            '蒙古'         => '亚洲',
            '缅甸'         => '亚洲',
            '文莱'         => '亚洲',
            '柬埔寨'        => '亚洲',
            '东帝汶'        => '亚洲',
            '印度尼西亚'      => '亚洲',
            '老挝'         => '亚洲',
            '马来西亚'       => '亚洲',
            '菲律宾'        => '亚洲',
            '新加坡'        => '亚洲',
            '泰国'         => '亚洲',
            '越南'         => '亚洲',
            '孟加拉国'       => '亚洲',
            '不丹'         => '亚洲',
            '印度'         => '亚洲',
            '马尔代夫'       => '亚洲',
            '尼泊尔'        => '亚洲',
            '巴基斯坦'       => '亚洲',
            '斯里兰卡'       => '亚洲',
            '哈萨克斯坦'      => '亚洲',
            '吉尔吉斯斯坦'     => '亚洲',
            '土库曼斯坦'      => '亚洲',
            '塔吉克斯坦'      => '亚洲',
            '乌兹别克斯坦'     => '亚洲',
            '阿富汗'        => '亚洲',
            '亚美尼亚'       => '亚洲',
            '阿塞拜疆'       => '亚洲',
            '巴林'         => '亚洲',
            '格鲁吉亚'       => '亚洲',
            '伊朗'         => '亚洲',
            '伊拉克'        => '亚洲',
            '以色列'        => '亚洲',
            '约旦'         => '亚洲',
            '科威特'        => '亚洲',
            '黎巴嫩'        => '亚洲',
            '阿曼'         => '亚洲',
            '巴勒斯坦'       => '亚洲',
            '卡塔尔'        => '亚洲',
            '沙特阿拉伯'      => '亚洲',
            '叙利亚'        => '亚洲',
            '阿拉伯联合酋长国'   => '亚洲',
            '也门'         => '亚洲',
            '比利时'        => '欧洲',
            '法国'         => '欧洲',
            '爱尔兰'        => '欧洲',
            '卢森堡'        => '欧洲',
            '摩纳哥'        => '欧洲',
            '荷兰'         => '欧洲',
            '英国'         => '欧洲',
            '奥地利'        => '欧洲',
            '德国'         => '欧洲',
            '列支敦士登'      => '欧洲',
            '瑞士'         => '欧洲',
            '丹麦'         => '欧洲',
            '芬兰'         => '欧洲',
            '冰岛'         => '欧洲',
            '挪威'         => '欧洲',
            '瑞典'         => '欧洲',
            '白俄罗斯'       => '欧洲',
            '爱沙尼亚'       => '欧洲',
            '拉脱维亚'       => '欧洲',
            '立陶宛'        => '欧洲',
            '摩尔多瓦'       => '欧洲',
            '俄罗斯'        => '欧洲',
            '乌克兰'        => '欧洲',
            '波兰'         => '欧洲',
            '斯洛伐克'       => '欧洲',
            '匈牙利'        => '欧洲',
            '捷克'         => '欧洲',
            '阿尔巴尼亚'      => '欧洲',
            '安道尔'        => '欧洲',
            '波黑'         => '欧洲',
            '保加利亚'       => '欧洲',
            '克罗地亚'       => '欧洲',
            '希腊'         => '欧洲',
            '意大利'        => '欧洲',
            '马其顿'        => '欧洲',
            '马耳他'        => '欧洲',
            '黑山'         => '欧洲',
            '葡萄牙'        => '欧洲',
            '罗马尼亚'       => '欧洲',
            '圣马力诺'       => '欧洲',
            '塞尔维亚'       => '欧洲',
            '斯洛文尼亚'      => '欧洲',
            '西班牙'        => '欧洲',
            '梵蒂冈'        => '欧洲',
            '塞浦路斯'       => '欧洲',
            '土耳其'        => '欧洲',
            '阿尔及利亚'      => '非洲',
            '埃及'         => '非洲',
            '利比亚'        => '非洲',
            '摩洛哥'        => '非洲',
            '苏丹'         => '非洲',
            '突尼斯'        => '非洲',
            '南苏丹'        => '非洲',
            '贝宁'         => '非洲',
            '布基纳法索'      => '非洲',
            '乍得'         => '非洲',
            '科特迪瓦'       => '非洲',
            '冈比亚'        => '非洲',
            '加纳'         => '非洲',
            '几内亚'        => '非洲',
            '几内亚比绍'      => '非洲',
            '利比里亚'       => '非洲',
            '马里'         => '非洲',
            '尼日尔'        => '非洲',
            '毛里塔尼亚'      => '非洲',
            '尼日利亚'       => '非洲',
            '塞内加尔'       => '非洲',
            '塞拉利昂'       => '非洲',
            '多哥'         => '非洲',
            '佛得角'        => '非洲',
            '喀麦隆'        => '非洲',
            '中非'         => '非洲',
            '赤道几内亚'      => '非洲',
            '加蓬'         => '非洲',
            '刚果共和国'      => '非洲',
            '刚果民主共和国'    => '非洲',
            '圣多美普林西比'    => '非洲',
            '安哥拉'        => '非洲',
            '博茨瓦纳'       => '非洲',
            '科摩罗'        => '非洲',
            '莱索托'        => '非洲',
            '马达加斯加'      => '非洲',
            '马拉维'        => '非洲',
            '毛里求斯'       => '非洲',
            '莫桑比克'       => '非洲',
            '纳米比亚'       => '非洲',
            '斯威士兰'       => '非洲',
            '南非'         => '非洲',
            '赞比亚'        => '非洲',
            '津巴布韦'       => '非洲',
            '布隆迪'        => '非洲',
            '吉布提'        => '非洲',
            '厄立特里亚'      => '非洲',
            '埃塞俄比亚'      => '非洲',
            '肯尼亚'        => '非洲',
            '卢旺达'        => '非洲',
            '塞舌尔'        => '非洲',
            '索马里'        => '非洲',
            '坦桑尼亚'       => '非洲',
            '乌干达'        => '非洲',
            '澳大利亚'       => '大洋洲',
            '斐济'         => '大洋洲',
            '基里巴斯'       => '大洋洲',
            '马绍尔群岛'      => '大洋洲',
            '密克罗尼西亚联邦'   => '大洋洲',
            '瑙鲁'         => '大洋洲',
            '新西兰'        => '大洋洲',
            '帕劳'         => '大洋洲',
            '巴布亚新几内亚'    => '大洋洲',
            '萨摩亚'        => '大洋洲',
            '所罗门群岛'      => '大洋洲',
            '汤加'         => '大洋洲',
            '图瓦卢'        => '大洋洲',
            '瓦努阿图'       => '大洋洲',
            '加拿大'        => '美洲',
            '墨西哥'        => '美洲',
            '美国'         => '美洲',
            '伯利兹'        => '美洲',
            '哥斯达黎加'      => '美洲',
            '萨尔瓦多'       => '美洲',
            '危地马拉'       => '美洲',
            '洪都拉斯'       => '美洲',
            '尼加拉瓜'       => '美洲',
            '巴拿马'        => '美洲',
            '安提瓜和巴布达'    => '美洲',
            '巴哈马'        => '美洲',
            '巴巴多斯'       => '美洲',
            '古巴'         => '美洲',
            '多米尼克'       => '美洲',
            '多米尼加共和国'    => '美洲',
            '格林纳达'       => '美洲',
            '海地'         => '美洲',
            '牙买加'        => '美洲',
            '圣克里斯多福与尼维斯' => '美洲',
            '圣卢西亚'       => '美洲',
            '圣文森特和格林纳丁斯' => '美洲',
            '特立尼达和多巴哥'   => '美洲',
            '阿根廷'        => '美洲',
            '玻利维亚'       => '美洲',
            '巴西'         => '美洲',
            '智利'         => '美洲',
            '哥伦比亚'       => '美洲',
            '厄瓜多尔'       => '美洲',
            '圭亚那'        => '美洲',
            '秘鲁'         => '美洲',
            '巴拉圭'        => '美洲',
            '苏里南'        => '美洲',
            '乌拉圭'        => '美洲',
            '委内瑞拉'       => '美洲',
        );
    }

    /**
     * @param int $areaCode
     * @return string
     */
    public static function getCountryByAreaCode(int $areaCode): string
    {
        $codes = static::getPhoneCodes();
        return $codes[$areaCode] ?? "";
    }

    /**
     * Get map between code and country
     * @return string[]
     */
    public static function getPhoneCodes(): array
    {
        return array(
            244  => '安哥拉',
            93   => '阿富汗',
            355  => '阿尔巴尼亚',
            213  => '阿尔及利亚',
            376  => '安道尔共和国',
            1264 => '安圭拉岛',
            1268 => '安提瓜和巴布达',
            54   => '阿根廷',
            374  => '亚美尼亚',
            247  => '阿森松',
            61   => '澳大利亚',
            43   => '奥地利',
            994  => '阿塞拜疆',
            1242 => '巴哈马',
            973  => '巴林',
            880  => '孟加拉国',
            1246 => '巴巴多斯',
            375  => '白俄罗斯',
            32   => '比利时',
            501  => '伯利兹',
            229  => '贝宁',
            1441 => '百慕大群岛',
            591  => '玻利维亚',
            267  => '博茨瓦纳',
            55   => '巴西',
            673  => '文莱',
            359  => '保加利亚',
            226  => '布基纳法索',
            95   => '缅甸',
            257  => '布隆迪',
            237  => '喀麦隆',
            1    => '美国',
            1345 => '开曼群岛',
            236  => '中非共和国',
            235  => '乍得',
            56   => '智利',
            86   => '中国',
            57   => '哥伦比亚',
            242  => '刚果',
            682  => '库克群岛',
            506  => '哥斯达黎加',
            53   => '古巴',
            357  => '塞浦路斯',
            420  => '捷克',
            45   => '丹麦',
            253  => '吉布提',
            1890 => '多米尼加共和国',
            593  => '厄瓜多尔',
            20   => '埃及',
            503  => '萨尔瓦多',
            372  => '爱沙尼亚',
            251  => '埃塞俄比亚',
            679  => '斐济',
            358  => '芬兰',
            33   => '法国',
            594  => '法属圭亚那',
            241  => '加蓬',
            220  => '冈比亚',
            995  => '格鲁吉亚',
            49   => '德国',
            233  => '乌兹别克斯坦',
            350  => '直布罗陀',
            30   => '希腊',
            1809 => '特立尼达和多巴哥',
            1671 => '关岛',
            502  => '危地马拉',
            224  => '几内亚',
            592  => '圭亚那',
            509  => '海地',
            504  => '洪都拉斯',
            852  => '香港',
            36   => '匈牙利',
            354  => '冰岛',
            91   => '印度',
            62   => '印度尼西亚',
            98   => '伊朗',
            964  => '伊拉克',
            353  => '爱尔兰',
            972  => '以色列',
            39   => '意大利',
            225  => '科特迪瓦',
            1876 => '牙买加',
            81   => '日本',
            962  => '约旦',
            855  => '柬埔寨',
            327  => '哈萨克斯坦',
            254  => '肯尼亚',
            82   => '韩国',
            965  => '科威特',
            331  => '吉尔吉斯坦',
            856  => '老挝',
            371  => '拉脱维亚',
            961  => '黎巴嫩',
            266  => '莱索托',
            231  => '利比里亚',
            218  => '利比亚',
            423  => '列支敦士登',
            370  => '立陶宛',
            352  => '卢森堡',
            853  => '澳门',
            261  => '马达加斯加',
            265  => '马拉维',
            60   => '马来西亚',
            960  => '马尔代夫',
            223  => '马里',
            356  => '马耳他',
            1670 => '马里亚那群岛',
            596  => '马提尼克',
            230  => '毛里求斯',
            52   => '墨西哥',
            373  => '摩尔多瓦',
            377  => '摩纳哥',
            976  => '蒙古',
            1664 => '蒙特塞拉特岛',
            212  => '摩洛哥',
            258  => '莫桑比克',
            264  => '纳米比亚',
            674  => '瑙鲁',
            977  => '尼泊尔',
            599  => '荷属安的列斯',
            31   => '荷兰',
            64   => '新西兰',
            505  => '尼加拉瓜',
            227  => '尼日尔',
            234  => '尼日利亚',
            850  => '朝鲜',
            47   => '挪威',
            968  => '阿曼',
            92   => '巴基斯坦',
            507  => '巴拿马',
            675  => '巴布亚新几内亚',
            595  => '巴拉圭',
            51   => '秘鲁',
            63   => '菲律宾',
            48   => '波兰',
            689  => '法属玻利尼西亚',
            351  => '葡萄牙',
            1787 => '波多黎各',
            974  => '卡塔尔',
            262  => '留尼旺',
            40   => '罗马尼亚',
            7    => '俄罗斯',
            1758 => '圣卢西亚',
            1784 => '圣文森特',
            684  => '东萨摩亚(美)',
            685  => '西萨摩亚',
            378  => '圣马力诺',
            239  => '圣多美和普林西比',
            966  => '沙特阿拉伯',
            221  => '塞内加尔',
            248  => '塞舌尔',
            232  => '塞拉利昂',
            65   => '新加坡',
            421  => '斯洛伐克',
            386  => '斯洛文尼亚',
            677  => '所罗门群岛',
            252  => '索马里',
            27   => '南非',
            34   => '西班牙',
            94   => '斯里兰卡',
            249  => '苏丹',
            597  => '苏里南',
            268  => '斯威士兰',
            46   => '瑞典',
            41   => '瑞士',
            963  => '叙利亚',
            886  => '台湾省',
            992  => '塔吉克斯坦',
            255  => '坦桑尼亚',
            66   => '泰国',
            228  => '多哥',
            676  => '汤加',
            216  => '突尼斯',
            90   => '土耳其',
            993  => '土库曼斯坦',
            256  => '乌干达',
            380  => '乌克兰',
            971  => '阿拉伯联合酋长国',
            44   => '英国',
            598  => '乌拉圭',
            58   => '委内瑞拉',
            84   => '越南',
            967  => '也门',
            381  => '南斯拉夫',
            263  => '津巴布韦',
            243  => '扎伊尔',
            260  => '赞比亚',
            //同步H5登录页面国家
            297  => '阿鲁巴',
            975  => '不丹',
            387  => '波黑',
            246  => '英属印度洋领地',
            1284 => '英属维尔京群岛',
            238  => '佛得角',
            269  => '科摩罗',
            385  => '克罗地亚',
            1767 => '多米尼克',
            240  => '赤道几内亚',
            291  => '厄立特里亚',
            500  => '福克兰群岛',
            298  => '法罗群岛',
            299  => '格陵兰岛',
            1473 => '格林纳达',
            590  => '瓜德罗普',
            245  => '几内亚比索',
            686  => '基里巴斯',
            383  => '科索沃',
            996  => '吉尔吉斯斯坦',
            389  => '北马其顿',
            692  => '马绍尔群岛',
            222  => '毛里塔尼亚',
            691  => '密克罗尼西亚联邦',
            382  => '黑山',
            687  => '新喀里多尼亚',
            683  => '纽埃',
            672  => '诺福克岛',
            680  => '帛琉',
            970  => '巴勒斯坦',
            250  => '卢旺达',
            290  => '圣赫勒拿岛',
            1869 => '圣基茨和尼维斯',
            508  => '圣皮埃尔和密克隆群岛',
            1721 => '荷属圣马丁',
            211  => '南苏丹',
            670  => '东帝汶',
            690  => '托克劳',
            1868 => '特立尼达和多巴哥',
            1649 => '特克斯和凯科斯群岛',
            688  => '图瓦卢',
            1340 => '美属维尔京群岛',
            998  => '乌兹别克斯坦',
            678  => '瓦努阿图',
            681  => '富图纳岛'
        );
    }

    /**
     * 常用数据非统一映射表
     * @return string[]
     */
    public static function getMapping(): array
    {
        return [
            '国内'      => '中国',
            '国外'      => '海外',
            '北京'      => '北京市',
            '河北'      => '河北省',
            '石家庄'     => '石家庄市',
            '唐山'      => '唐山市',
            '秦皇岛'     => '秦皇岛市',
            '邯郸'      => '邯郸市',
            '邢台'      => '邢台市',
            '保定'      => '保定市',
            '张家口'     => '张家口市',
            '承德'      => '承德市',
            '沧州'      => '沧州市',
            '廊坊'      => '廊坊市',
            '衡水'      => '衡水市',
            '天津'      => '天津市',
            '山西'      => '山西省',
            '太原'      => '太原市',
            '大同'      => '大同市',
            '阳泉'      => '阳泉市',
            '长治'      => '长治市',
            '晋城'      => '晋城市',
            '朔州'      => '朔州市',
            '晋中'      => '晋中市',
            '运城'      => '运城市',
            '忻州'      => '忻州市',
            '临汾'      => '临汾市',
            '吕梁'      => '吕梁市',
            '内蒙古'     => '内蒙古自治区',
            '呼和浩特'    => '呼和浩特市',
            '包头'      => '包头市',
            '乌海'      => '乌海市',
            '赤峰'      => '赤峰市',
            '通辽'      => '通辽市',
            '鄂尔多斯'    => '鄂尔多斯市',
            '呼伦贝尔'    => '呼伦贝尔市',
            '巴彦淖尔'    => '巴彦淖尔市',
            '乌兰察布'    => '乌兰察布市',
            '兴安'      => '兴安盟',
            '锡林郭勒'    => '锡林郭勒盟',
            '阿拉善'     => '阿拉善盟',
            '辽宁'      => '辽宁省',
            '沈阳'      => '沈阳市',
            '大连'      => '大连市',
            '鞍山'      => '鞍山市',
            '抚顺'      => '抚顺市',
            '本溪'      => '本溪市',
            '丹东'      => '丹东市',
            '锦州'      => '锦州市',
            '营口'      => '营口市',
            '阜新'      => '阜新市',
            '辽阳'      => '辽阳市',
            '盘锦'      => '盘锦市',
            '铁岭'      => '铁岭市',
            '朝阳'      => '朝阳市',
            '葫芦岛'     => '葫芦岛市',
            '吉林'      => '吉林省',
            '长春'      => '长春市',
            '吉林市'     => '吉林市',
            '四平'      => '四平市',
            '辽源'      => '辽源市',
            '通化'      => '通化市',
            '白山'      => '白山市',
            '松原'      => '松原市',
            '白城'      => '白城市',
            '延吉'      => '延边朝鲜族自治州',
            '黑龙江'     => '黑龙江省',
            '哈尔滨'     => '哈尔滨市',
            '齐齐哈尔'    => '齐齐哈尔市',
            '鸡西'      => '鸡西市',
            '鹤岗'      => '鹤岗市',
            '双鸭山'     => '双鸭山市',
            '大庆'      => '大庆市',
            '伊春'      => '伊春市',
            '佳木斯'     => '佳木斯市',
            '七台河'     => '七台河市',
            '牡丹江'     => '牡丹江市',
            '黑河'      => '黑河市',
            '绥化'      => '绥化市',
            '大兴安岭'    => '大兴安岭地区',
            '上海'      => '上海市',
            '江苏'      => '江苏省',
            '南京'      => '南京市',
            '无锡'      => '无锡市',
            '徐州'      => '徐州市',
            '常州'      => '常州市',
            '苏州'      => '苏州市',
            '南通'      => '南通市',
            '连云港'     => '连云港市',
            '淮安'      => '淮安市',
            '盐城'      => '盐城市',
            '扬州'      => '扬州市',
            '镇江'      => '镇江市',
            '泰州'      => '泰州市',
            '宿迁'      => '宿迁市',
            '浙江'      => '浙江省',
            '杭州'      => '杭州市',
            '宁波'      => '宁波市',
            '温州'      => '温州市',
            '嘉兴'      => '嘉兴市',
            '湖州'      => '湖州市',
            '绍兴'      => '绍兴市',
            '金华'      => '金华市',
            '衢州'      => '衢州市',
            '舟山'      => '舟山市',
            '台州'      => '台州市',
            '丽水'      => '丽水市',
            '安徽'      => '安徽省',
            '合肥'      => '合肥市',
            '芜湖'      => '芜湖市',
            '蚌埠'      => '蚌埠市',
            '淮南'      => '淮南市',
            '马鞍山'     => '马鞍山市',
            '淮北'      => '淮北市',
            '铜陵'      => '铜陵市',
            '安庆'      => '安庆市',
            '黄山'      => '黄山市',
            '滁州'      => '滁州市',
            '阜阳'      => '阜阳市',
            '宿州'      => '宿州市',
            '六安'      => '六安市',
            '亳州'      => '亳州市',
            '池州'      => '池州市',
            '宣城'      => '宣城市',
            '福建'      => '福建省',
            '福州'      => '福州市',
            '厦门'      => '厦门市',
            '莆田'      => '莆田市',
            '三明'      => '三明市',
            '泉州'      => '泉州市',
            '漳州'      => '漳州市',
            '南平'      => '南平市',
            '龙岩'      => '龙岩市',
            '宁德'      => '宁德市',
            '江西'      => '江西省',
            '南昌'      => '南昌市',
            '景德镇'     => '景德镇市',
            '萍乡'      => '萍乡市',
            '九江'      => '九江市',
            '新余'      => '新余市',
            '鹰潭'      => '鹰潭市',
            '赣州'      => '赣州市',
            '吉安'      => '吉安市',
            '宜春'      => '宜春市',
            '抚州'      => '抚州市',
            '上饶'      => '上饶市',
            '山东'      => '山东省',
            '济南'      => '济南市',
            '青岛'      => '青岛市',
            '淄博'      => '淄博市',
            '枣庄'      => '枣庄市',
            '东营'      => '东营市',
            '烟台'      => '烟台市',
            '潍坊'      => '潍坊市',
            '济宁'      => '济宁市',
            '泰安'      => '泰安市',
            '威海'      => '威海市',
            '日照'      => '日照市',
            '临沂'      => '临沂市',
            '德州'      => '德州市',
            '聊城'      => '聊城市',
            '滨州'      => '滨州市',
            '菏泽'      => '菏泽市',
            '河南'      => '河南省',
            '郑州'      => '郑州市',
            '开封'      => '开封市',
            '洛阳'      => '洛阳市',
            '平顶山'     => '平顶山市',
            '安阳'      => '安阳市',
            '鹤壁'      => '鹤壁市',
            '新乡'      => '新乡市',
            '焦作'      => '焦作市',
            '濮阳'      => '濮阳市',
            '许昌'      => '许昌市',
            '漯河'      => '漯河市',
            '三门峡'     => '三门峡市',
            '南阳'      => '南阳市',
            '商丘'      => '商丘市',
            '信阳'      => '信阳市',
            '周口'      => '周口市',
            '驻马店'     => '驻马店市',
            '济源'      => '济源市',
            '湖北'      => '湖北省',
            '武汉'      => '武汉市',
            '黄石'      => '黄石市',
            '十堰'      => '十堰市',
            '宜昌'      => '宜昌市',
            '襄阳'      => '襄阳市',
            '鄂州'      => '鄂州市',
            '荆门'      => '荆门市',
            '孝感'      => '孝感市',
            '荆州'      => '荆州市',
            '黄冈'      => '黄冈市',
            '咸宁'      => '咸宁市',
            '随州'      => '随州市',
            '恩施'      => '恩施土家族苗族自治州',
            '仙桃'      => '仙桃市',
            '潜江'      => '潜江市',
            '天门'      => '天门市',
            '神农架'     => '神农架林区',
            '湖南'      => '湖南省',
            '长沙'      => '长沙市',
            '株洲'      => '株洲市',
            '湘潭'      => '湘潭市',
            '衡阳'      => '衡阳市',
            '邵阳'      => '邵阳市',
            '岳阳'      => '岳阳市',
            '常德'      => '常德市',
            '张家界'     => '张家界市',
            '益阳'      => '益阳市',
            '郴州'      => '郴州市',
            '永州'      => '永州市',
            '怀化'      => '怀化市',
            '娄底'      => '娄底市',
            '吉首'      => '湘西土家族苗族自治州',
            '广东'      => '广东省',
            '广州'      => '广州市',
            '韶关'      => '韶关市',
            '深圳'      => '深圳市',
            '珠海'      => '珠海市',
            '汕头'      => '汕头市',
            '佛山'      => '佛山市',
            '江门'      => '江门市',
            '湛江'      => '湛江市',
            '茂名'      => '茂名市',
            '肇庆'      => '肇庆市',
            '惠州'      => '惠州市',
            '梅州'      => '梅州市',
            '汕尾'      => '汕尾市',
            '河源'      => '河源市',
            '阳江'      => '阳江市',
            '清远'      => '清远市',
            '东莞'      => '东莞市',
            '中山'      => '中山市',
            '潮州'      => '潮州市',
            '揭阳'      => '揭阳市',
            '云浮'      => '云浮市',
            '广西'      => '广西壮族自治区',
            '南宁'      => '南宁市',
            '柳州'      => '柳州市',
            '桂林'      => '桂林市',
            '梧州'      => '梧州市',
            '北海'      => '北海市',
            '防城港'     => '防城港市',
            '钦州'      => '钦州市',
            '贵港'      => '贵港市',
            '玉林'      => '玉林市',
            '百色'      => '百色市',
            '贺州'      => '贺州市',
            '河池'      => '河池市',
            '来宾'      => '来宾市',
            '崇左'      => '崇左市',
            '海南'      => '海南省',
            '海口'      => '海口市',
            '三亚'      => '三亚市',
            '三沙'      => '三沙市',
            '儋州'      => '儋州市',
            '五指山'     => '五指山市',
            '琼海'      => '琼海市',
            '文昌'      => '文昌市',
            '万宁'      => '万宁市',
            '东方'      => '东方市',
            '定安'      => '定安县',
            '屯昌'      => '屯昌县',
            '澄迈'      => '澄迈县',
            '临高'      => '临高县',
            '白沙'      => '白沙黎族自治县',
            '昌江'      => '昌江黎族自治县',
            '乐东'      => '乐东黎族自治县',
            '陵水'      => '陵水黎族自治县',
            '保亭'      => '保亭黎族苗族自治县',
            '琼中'      => '琼中黎族苗族自治县',
            '重庆'      => '重庆市',
            '四川'      => '四川省',
            '成都'      => '成都市',
            '自贡'      => '自贡市',
            '攀枝花'     => '攀枝花市',
            '泸州'      => '泸州市',
            '德阳'      => '德阳市',
            '绵阳'      => '绵阳市',
            '广元'      => '广元市',
            '遂宁'      => '遂宁市',
            '内江'      => '内江市',
            '乐山'      => '乐山市',
            '南充'      => '南充市',
            '眉山'      => '眉山市',
            '宜宾'      => '宜宾市',
            '广安'      => '广安市',
            '达州'      => '达州市',
            '雅安'      => '雅安市',
            '巴中'      => '巴中市',
            '资阳'      => '资阳市',
            '阿坝'      => '阿坝藏族羌族自治州',
            '甘孜'      => '甘孜藏族自治州',
            '凉山'      => '凉山彝族自治州',
            '贵州'      => '贵州省',
            '贵阳'      => '贵阳市',
            '六盘水'     => '六盘水市',
            '遵义'      => '遵义市',
            '安顺'      => '安顺市',
            '毕节'      => '毕节市',
            '铜仁'      => '铜仁市',
            '黔西南'     => '黔西南布依族苗族自治州',
            '黔东南'     => '黔东南苗族侗族自治州',
            '黔南'      => '黔南布依族苗族自治州',
            '云南'      => '云南省',
            '昆明'      => '昆明市',
            '曲靖'      => '曲靖市',
            '玉溪'      => '玉溪市',
            '保山'      => '保山市',
            '昭通'      => '昭通市',
            '丽江'      => '丽江市',
            '普洱'      => '普洱市',
            '临沧'      => '临沧市',
            '楚雄'      => '楚雄彝族自治州',
            '红河'      => '红河哈尼族彝族自治州',
            '文山'      => '文山壮族苗族自治州',
            '西双版纳'    => '西双版纳傣族自治州',
            '大理'      => '大理白族自治州',
            '德宏'      => '德宏傣族景颇族自治州',
            '怒江'      => '怒江傈僳族自治州',
            '迪庆'      => '迪庆藏族自治州',
            '西藏'      => '西藏自治区',
            '拉萨'      => '拉萨市',
            '日喀则'     => '日喀则市',
            '昌都'      => '昌都市',
            '林芝'      => '林芝市',
            '山南'      => '山南市',
            '那曲'      => '那曲市',
            '阿里'      => '阿里地区',
            '陕西'      => '陕西省',
            '西安'      => '西安市',
            '铜川'      => '铜川市',
            '宝鸡'      => '宝鸡市',
            '咸阳'      => '咸阳市',
            '渭南'      => '渭南市',
            '延安'      => '延安市',
            '汉中'      => '汉中市',
            '榆林'      => '榆林市',
            '安康'      => '安康市',
            '商洛'      => '商洛市',
            '甘肃'      => '甘肃省',
            '兰州'      => '兰州市',
            '嘉峪关'     => '嘉峪关市',
            '金昌'      => '金昌市',
            '白银'      => '白银市',
            '天水'      => '天水市',
            '武威'      => '武威市',
            '张掖'      => '张掖市',
            '平凉'      => '平凉市',
            '酒泉'      => '酒泉市',
            '庆阳'      => '庆阳市',
            '定西'      => '定西市',
            '陇南'      => '陇南市',
            '临夏'      => '临夏回族自治州',
            '甘南'      => '甘南藏族自治州',
            '青海'      => '青海省',
            '西宁'      => '西宁市',
            '海东'      => '海东市',
            '海北'      => '海北藏族自治州',
            '黄南州'     => '黄南藏族自治州',
            '海南州'     => '海南藏族自治州',
            '果洛'      => '果洛藏族自治州',
            '玉树州'     => '玉树藏族自治州',
            '海西'      => '海西蒙古族藏族自治州',
            '宁夏回族自治区' => '宁夏',
            '银川'      => '银川市',
            '石嘴山'     => '石嘴山市',
            '吴忠'      => '吴忠市',
            '固原'      => '固原市',
            '中卫'      => '中卫市',
            '新疆'      => '新疆维吾尔自治区',
            '乌鲁木齐'    => '乌鲁木齐市',
            '克拉玛依'    => '克拉玛依市',
            '吐鲁番'     => '吐鲁番市',
            '哈密'      => '哈密市',
            '昌吉'      => '昌吉回族自治州',
            '博尔塔拉'    => '博尔塔拉蒙古自治州',
            '巴音郭楞'    => '巴音郭楞蒙古自治州',
            '阿克苏'     => '阿克苏地区',
            '克孜勒苏'    => '克孜勒苏柯尔克孜自治州',
            '喀什'      => '喀什地区',
            '和田'      => '和田地区',
            '伊犁'      => '伊犁哈萨克自治州',
            '塔城'      => '塔城地区',
            '阿勒泰'     => '阿勒泰地区',
            '石河子'     => '石河子市',
            '阿拉尔'     => '阿拉尔市',
            '图木舒克'    => '图木舒克市',
            '五家渠'     => '五家渠市',
            '铁门关'     => '铁门关市',
            '香港'      => '香港',
            '台湾'      => '台湾省',
            '台北'      => '台北市',
            '新北'      => '新北市',
            '桃园'      => '桃园市',
            '台中'      => '台中市',
            '台南'      => '台南市',
            '高雄'      => '高雄市',
            '澳门'      => '澳门'
        ];
    }
}
