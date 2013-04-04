SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `horoscope_constellations`;
CREATE TABLE IF NOT EXISTS `horoscope_constellations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name_hiragana` text NOT NULL,
  `name_kanji` text NOT NULL,
  `start_month` int(11) NOT NULL,
  `start_day` int(11) NOT NULL,
  `end_month` int(11) NOT NULL,
  `end_day` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

INSERT INTO `horoscope_constellations` (`id`, `code`, `name_hiragana`, `name_kanji`, `start_month`, `start_day`, `end_month`, `end_day`) VALUES
(1, 'aries', 'おひつじ座', '牡羊座', 3, 21, 4, 20),
(2, 'taurus', 'おうし座', '牡牛座', 4, 21, 5, 20),
(3, 'gemini', 'ふたご座', '双子座', 5, 21, 6, 20),
(4, 'cancer', 'かに座', '蟹座', 6, 21, 7, 22),
(5, 'leo', 'しし座', '獅子座', 7, 23, 8, 22),
(6, 'virgo', 'おとめ座', '乙女座', 8, 23, 9, 22),
(7, 'libra', 'てんびん座', '天秤座', 9, 23, 10, 23),
(8, 'scorpio', 'さそり座', '蠍座', 10, 24, 11, 21),
(9, 'sagittarius', 'いて座', '射手座', 11, 22, 12, 21),
(10, 'capricornus', 'やぎ座', '山羊座', 12, 22, 1, 19),
(11, 'aquarius', 'みずがめ座', '水瓶座', 1, 20, 2, 19),
(12, 'pisces', 'うお座', '魚座', 2, 20, 3, 20);

DROP TABLE IF EXISTS `horoscope_results`;
CREATE TABLE IF NOT EXISTS `horoscope_results` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `content` text NOT NULL,
  `money` int(11) NOT NULL,
  `job` int(11) NOT NULL,
  `love` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `item` text NOT NULL,
  `color` text NOT NULL,
  `rank` int(11) NOT NULL,
  `constellation_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4453 ;
