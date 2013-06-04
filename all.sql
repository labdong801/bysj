-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 06 月 04 日 14:15
-- 服务器版本: 5.5.31
-- PHP 版本: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `bysj`
--

-- --------------------------------------------------------

--
-- 表的结构 `art_instrument_student_select`
--

CREATE TABLE IF NOT EXISTS `art_instrument_student_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(16) CHARACTER SET gb2312 NOT NULL,
  `first` tinyint(4) NOT NULL,
  `second` tinyint(4) NOT NULL,
  `third` tinyint(4) NOT NULL,
  `finally` tinyint(4) NOT NULL,
  `teacher` varchar(25) NOT NULL,
  `year` varchar(4) NOT NULL,
  `lock` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `art_instrument_student_select`
--

INSERT INTO `art_instrument_student_select` (`id`, `student_number`, `first`, `second`, `third`, `finally`, `teacher`, `year`, `lock`) VALUES
(1, '12104880201', 13, 14, 15, 0, '', '2012', 1),
(2, '12104880202', 13, 14, 15, 0, '', '2012', 1),
(3, '12104880203', 13, 15, 14, 0, '', '2012', 1),
(4, '12104880204', 14, 13, 15, 0, '', '2012', 1),
(5, '12104880205', 14, 13, 15, 0, '', '2012', 1),
(6, '12104880206', 13, 15, 16, 0, '', '2012', 1),
(7, '12104880207', 13, 14, 15, 0, '', '2012', 1),
(8, '12104880209', 14, 15, 13, 0, '', '2012', 0),
(9, '12104880210', 14, 15, 13, 0, '', '2012', 0),
(10, '12104880212', 15, 13, 14, 0, '', '2012', 1),
(11, '12104880214', 13, 14, 15, 0, '', '2012', 1);

-- --------------------------------------------------------

--
-- 表的结构 `art_major`
--

CREATE TABLE IF NOT EXISTS `art_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) CHARACTER SET gb2312 NOT NULL,
  `icon` varchar(100) NOT NULL,
  `detail` varchar(400) CHARACTER SET gb2312 NOT NULL,
  `grade` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `art_major`
--

INSERT INTO `art_major` (`id`, `name`, `icon`, `detail`, `grade`) VALUES
(1, '声乐', '\\images\\instrument\\shengyue.png', 'sadsafsafffffffffffffffffffasdasdasdasfasfasfasfasfasd', 3),
(2, '钢琴', '\\images\\instrument\\gangqin.png', 'gangqingangqingangqin', 3),
(3, '舞蹈', '\\images\\instrument\\wudao.png', 'wudaodasafasfasfasdasdasgfasda', 3),
(4, '合唱指挥', '\\images\\instrument\\zhihui.png', 'zhihui', 3),
(5, '二胡', '\\images\\instrument\\erhu.png', 'erhuerhuasdkakslcajkshjadlsad', 3),
(6, '小提琴', '\\images\\instrument\\xiaotiqin.png', 'iasjdasjfklasjklajskldjasdads', 3),
(7, '萨克斯/黑管', '\\images\\instrument\\shakesi.png', 'sadasfasfasfasfasfasdasdasd', 3),
(8, '中国音乐理论', '\\images\\instrument\\zhongguo.png', '1241241252131231231241241241241241', 3),
(9, '作曲技术理论', '\\images\\instrument\\zuoqu.png', 'sadasdasfasfasfasdas', 3),
(10, '外国音乐理论', '\\images\\instrument\\waiguo.png', 'sajkasdhasjdkasdjlaksjdlasjdklasjdkasjdklasjkdajskdjalsdjas', 3),
(11, '声乐', '', '', 2),
(12, '钢琴', '', '', 2),
(13, '小提琴', '\\images\\instrument\\xiaotiqin.png', '小提琴小提琴小提琴小提琴小提琴小提琴小提琴', 1),
(14, '古筝', '\\images\\instrument\\guzheng.png', '古筝古筝古筝古筝古筝', 1),
(15, '长笛', '\\images\\instrument\\changdi.png', '长笛长笛长笛长笛长笛', 1),
(16, '萨克斯/黑管', '\\images\\instrument\\shakesi.png', '萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管', 1),
(17, '二胡', '\\images\\instrument\\erhu.png', '二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡', 1),
(18, '毕业设计', '', '', 4);

-- --------------------------------------------------------

--
-- 表的结构 `art_major_student_select`
--

CREATE TABLE IF NOT EXISTS `art_major_student_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(16) CHARACTER SET gb2312 NOT NULL,
  `first` tinyint(4) NOT NULL,
  `second` tinyint(4) NOT NULL,
  `third` tinyint(4) NOT NULL,
  `finally` tinyint(4) NOT NULL,
  `teacher` varchar(25) NOT NULL,
  `year` varchar(4) NOT NULL,
  `lock` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `art_major_student_select`
--

INSERT INTO `art_major_student_select` (`id`, `student_number`, `first`, `second`, `third`, `finally`, `teacher`, `year`, `lock`) VALUES
(1, '10104010101', 2, 1, 3, 0, '', '2012', 0),
(2, '10104010102', 2, 1, 3, 0, '', '2012', 0),
(3, '10104010103', 1, 3, 2, 0, '', '2012', 0),
(4, '10104010105', 2, 1, 3, 0, '', '2012', 0),
(5, '10104010106', 5, 4, 2, 0, '', '2012', 0),
(6, '10104010107', 1, 2, 3, 0, '', '2012', 0),
(7, '10104010108', 1, 2, 3, 0, '', '2012', 0),
(8, '10104010109', 4, 3, 2, 0, '', '2012', 0),
(9, '10104010110', 5, 4, 2, 0, '', '2012', 0),
(10, '10104010111', 3, 2, 1, 0, '', '2012', 0);

-- --------------------------------------------------------

--
-- 表的结构 `art_set_date`
--

CREATE TABLE IF NOT EXISTS `art_set_date` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `grade` tinyint(4) NOT NULL COMMENT '所属年级',
  `topic_start` int(11) NOT NULL COMMENT '教师提交时间',
  `topic_end` int(11) NOT NULL COMMENT '教师截止时间',
  `student_start` int(11) NOT NULL COMMENT '学生选题时间',
  `student_end` int(11) NOT NULL COMMENT '学生截止时间',
  `teacher_start` int(11) NOT NULL COMMENT '选学生开始时间',
  `teacher_end` int(11) NOT NULL COMMENT '选学生结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `art_set_date`
--

INSERT INTO `art_set_date` (`id`, `grade`, `topic_start`, `topic_end`, `student_start`, `student_end`, `teacher_start`, `teacher_end`) VALUES
(10, 1, 0, 0, 1367337600, 1372607999, 1367337600, 1372607999),
(11, 2, 0, 0, 1367769600, 1372521599, 1370448000, 1373126399),
(12, 3, 0, 0, 1369065600, 1371830399, 1367424000, 1372521599),
(13, 4, 1368547200, 1370015999, 1369238400, 1372348799, 1367424000, 1373299199);

-- --------------------------------------------------------

--
-- 表的结构 `art_student_task`
--

CREATE TABLE IF NOT EXISTS `art_student_task` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `major_id` int(4) NOT NULL,
  `classes` varchar(50) COLLATE gb2312_bin NOT NULL,
  `task_id` varchar(2) COLLATE gb2312_bin NOT NULL,
  `file_name` varchar(50) COLLATE gb2312_bin NOT NULL,
  `status` int(1) NOT NULL,
  `year` varchar(20) CHARACTER SET latin1 NOT NULL,
  `teacher_id` varchar(50) CHARACTER SET latin1 NOT NULL,
  `sd_grade` int(2) NOT NULL,
  `student_num` varchar(16) CHARACTER SET gb2312 NOT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312 COLLATE=gb2312_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_teacher_student`
--

CREATE TABLE IF NOT EXISTS `art_teacher_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `major_id` int(11) NOT NULL,
  `teacher_id` varchar(25) CHARACTER SET gb2312 NOT NULL,
  `class` tinyint(4) NOT NULL,
  `year` varchar(4) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- 转存表中的数据 `art_teacher_student`
--

INSERT INTO `art_teacher_student` (`id`, `major_id`, `teacher_id`, `class`, `year`, `value`) VALUES
(1, 13, 'fj902', 20, '2012', 30),
(2, 13, 'fj902', 23, '2012', 30),
(3, 12, 'fj902', 20, '2012', 10),
(4, 12, 'fj902', 23, '2012', 10),
(5, 2, 'fj902', 20, '2012', 10),
(6, 2, 'fj902', 23, '2012', 10),
(7, 18, 'fj902', 20, '2012', 5),
(8, 18, 'fj902', 23, '2012', 5),
(9, 13, 'dj901', 20, '2012', 0),
(10, 15, 'dj901', 20, '2012', 20),
(11, 15, 'dj901', 23, '2012', 20),
(12, 12, 'dj901', 20, '2012', 10),
(13, 12, 'dj901', 23, '2012', 10),
(14, 11, 'dj901', 20, '2012', 5),
(15, 11, 'dj901', 23, '2012', 5),
(16, 1, 'dj901', 20, '2012', 10),
(17, 1, 'dj901', 23, '2012', 10),
(18, 18, 'dj901', 20, '2012', 5),
(19, 18, 'dj901', 23, '2012', 5),
(20, 13, 'cgl903', 20, '2012', 20),
(21, 13, 'cgl903', 23, '2012', 20),
(22, 17, 'cgl903', 20, '2012', 10),
(23, 17, 'cgl903', 23, '2012', 10),
(24, 15, 'cgl903', 20, '2012', 5),
(25, 15, 'cgl903', 23, '2012', 5),
(26, 11, 'cgl903', 20, '2012', 5),
(27, 11, 'cgl903', 23, '2012', 5),
(28, 1, 'cgl903', 20, '2012', 20),
(29, 1, 'cgl903', 23, '2012', 20),
(30, 7, 'cgl903', 20, '2012', 20),
(31, 7, 'cgl903', 23, '2012', 20),
(32, 18, 'cgl903', 20, '2012', 5),
(33, 18, 'cgl903', 23, '2012', 5),
(34, 13, 'cwj904', 20, '2012', 20),
(35, 14, 'cwj904', 20, '2012', 0),
(36, 14, 'cwj904', 23, '2012', 30),
(37, 12, 'cwj904', 20, '2012', 0),
(38, 11, 'cwj904', 20, '2012', 20),
(39, 11, 'cwj904', 23, '2012', 20),
(40, 3, 'cwj904', 20, '2012', 20),
(41, 3, 'cwj904', 23, '2012', 20),
(42, 18, 'cwj904', 20, '2012', 6),
(43, 18, 'cwj904', 23, '2012', 3),
(44, 13, 'yxx905', 20, '2012', 0),
(45, 15, 'yxx905', 20, '2012', 20),
(46, 15, 'yxx905', 23, '2012', 20),
(47, 12, 'yxx905', 20, '2012', 5),
(48, 12, 'yxx905', 23, '2012', 5),
(49, 18, 'yxx905', 20, '2012', 7),
(50, 18, 'yxx905', 23, '2012', 4),
(51, 4, 'yxx905', 20, '2012', 30),
(52, 4, 'yxx905', 23, '2012', 30);

-- --------------------------------------------------------

--
-- 表的结构 `art_teacher_task`
--

CREATE TABLE IF NOT EXISTS `art_teacher_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `content` varchar(1000) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `start_time` varchar(100) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `end_time` varchar(100) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `teacher_task` varchar(100) NOT NULL,
  `class` int(2) NOT NULL,
  `year_task` varchar(20) NOT NULL,
  `major_id` int(4) NOT NULL,
  `grade` int(2) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_title_sort`
--

CREATE TABLE IF NOT EXISTS `art_title_sort` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '选题类别id',
  `name` varchar(30) NOT NULL COMMENT '选题类别名称',
  `open` tinyint(1) NOT NULL COMMENT '开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `art_title_sort`
--

INSERT INTO `art_title_sort` (`id`, `name`, `open`) VALUES
(4, '课程教学', 1),
(5, '科学研究', 1),
(6, '测试', 1);

-- --------------------------------------------------------

--
-- 表的结构 `art_vocalmusic`
--

CREATE TABLE IF NOT EXISTS `art_vocalmusic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` varchar(25) NOT NULL,
  `vocalmusic` tinyint(4) NOT NULL,
  `piano` tinyint(4) NOT NULL,
  `year` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `art_vocalmusic`
--

INSERT INTO `art_vocalmusic` (`id`, `teacher_id`, `vocalmusic`, `piano`, `year`) VALUES
(1, 'ty911', 0, 1, '2013'),
(2, 'fj902', 0, 1, '2013'),
(3, 'cxy910', 0, 1, '2013'),
(4, 'dj901', 1, 0, '2013'),
(5, 'cgl903', 1, 0, '2013'),
(6, 'yxx905', 1, 0, '2013'),
(7, 'lcm913', 1, 0, '2013');

-- --------------------------------------------------------

--
-- 表的结构 `art_vocalmusic_student_select`
--

CREATE TABLE IF NOT EXISTS `art_vocalmusic_student_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(25) CHARACTER SET gb2312 NOT NULL,
  `vocalmusic_first` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_second` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_third` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_finally` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_lock` tinyint(4) NOT NULL,
  `piano_first` varchar(25) NOT NULL DEFAULT '0',
  `piano_second` varchar(25) NOT NULL DEFAULT '0',
  `piano_third` varchar(25) NOT NULL DEFAULT '0',
  `piano_finally` varchar(25) NOT NULL DEFAULT '0',
  `piano_lock` tinyint(1) NOT NULL,
  `year` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `art_vocalmusic_student_select`
--

INSERT INTO `art_vocalmusic_student_select` (`id`, `student_number`, `vocalmusic_first`, `vocalmusic_second`, `vocalmusic_third`, `vocalmusic_finally`, `vocalmusic_lock`, `piano_first`, `piano_second`, `piano_third`, `piano_finally`, `piano_lock`, `year`) VALUES
(1, '11104010101', 'dj901', 'cgl903', 'yxx905', '0', 0, 'fj902', 'ty911', 'cxy910', '0', 0, '2012'),
(2, '11104010102', 'dj901', 'cgl903', 'yxx905', '0', 0, 'fj902', 'ty911', 'cxy910', '0', 0, '2012'),
(3, '11104010103', 'dj901', 'cgl903', 'yxx905', '0', 0, 'ty911', 'fj902', 'cxy910', '0', 0, '2012'),
(4, '11104010104', '0', '0', '0', '0', 0, 'ty911', 'fj902', 'cxy910', '0', 0, '2012'),
(5, '11104010105', '0', '0', '0', '0', 0, 'fj902', 'ty911', 'cxy910', '0', 0, '2012'),
(6, '11104010106', '0', '0', '0', '0', 0, 'fj902', 'ty911', 'cxy910', '0', 0, '2012'),
(7, '11104010107', 'dj901', 'cgl903', 'yxx905', '0', 0, 'ty911', 'fj902', 'cxy910', '0', 0, '2012'),
(8, '11104010109', '0', '0', '0', '0', 0, 'ty911', 'cxy910', 'fj902', '0', 0, '2012'),
(9, '11104010110', '0', '0', '0', '0', 0, 'ty911', 'cxy910', 'fj902', '0', 0, '2012');

-- --------------------------------------------------------

--
-- 表的结构 `bysj_checkin`
--

CREATE TABLE IF NOT EXISTS `bysj_checkin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `student_id` varchar(11) CHARACTER SET gb2312 NOT NULL COMMENT '学生ID',
  `teacher_id` varchar(20) CHARACTER SET gb2312 NOT NULL DEFAULT 'nobody' COMMENT '指导老师',
  `checktime` int(11) NOT NULL COMMENT '签到时间',
  `work` tinyint(4) NOT NULL DEFAULT '0' COMMENT '工作状态',
  `city` varchar(30) CHARACTER SET gb2312 NOT NULL COMMENT '所在地名',
  `company` varchar(60) CHARACTER SET gb2312 NOT NULL COMMENT '公司名称',
  `mobile` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '联系电话',
  `backtime` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回校预计日期',
  `progress` tinyint(4) NOT NULL DEFAULT '0' COMMENT '设计进度',
  `memo` varchar(50) CHARACTER SET gb2312 NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk COMMENT='签到表' AUTO_INCREMENT=1203 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_examine3`
--

CREATE TABLE IF NOT EXISTS `bysj_examine3` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `student_id` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '学生ID',
  `teacher_id` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '教师ID',
  `score1` float NOT NULL DEFAULT '0',
  `score2` float NOT NULL DEFAULT '0',
  `score3` float NOT NULL DEFAULT '0',
  `score4` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=3126 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_major`
--

CREATE TABLE IF NOT EXISTS `bysj_major` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT COMMENT '专业id',
  `name` varchar(40) NOT NULL COMMENT '专业名称',
  `shortname` varchar(20) NOT NULL COMMENT '简称',
  `type` tinyint(4) NOT NULL COMMENT '单位级别',
  `h_level` tinyint(4) NOT NULL COMMENT '单位上级',
  `open` tinyint(2) NOT NULL COMMENT '开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `bysj_major`
--

INSERT INTO `bysj_major` (`id`, `name`, `shortname`, `type`, `h_level`, `open`) VALUES
(1, '电子信息工程', '电信', 4, 12, 1),
(2, '电子信息科学与技术', '电子', 4, 12, 1),
(3, '应用电子技术（专科）', '电子专', 4, 12, 0),
(4, '电气工程及其自动化', '电气', 4, 13, 1),
(5, '自动化', '自动化', 4, 13, 1),
(7, '测控技术与仪器', '测控', 4, 13, 1),
(8, '电气自动化技术（专科）', '电气专', 4, 13, 1),
(9, '计算机科学与技术', '计算机', 4, 14, 0),
(10, '网络工程', '网络', 4, 14, 0),
(11, '网络工程与技术（专科）', '网络专', 4, 14, 0),
(12, '电子信息工程系', '电信系', 3, 16, 1),
(13, '自动化系', '自动化系', 3, 16, 1),
(14, '计算机科学与技术系', '计算机系', 3, 16, 1),
(15, '电工电子教学与实验中心', '电工电子实验室', 3, 16, 1),
(16, '计算机与电子信息学院', '信息学院', 2, 17, 1),
(17, '广东石油化工学院', '学校', 1, 0, 1),
(18, '艺术系', '艺术系', 2, 17, 1),
(19, '艺术系', '艺术', 3, 18, 1),
(20, '音乐学', '音乐', 4, 19, 1),
(21, '图书馆', '图书馆', 2, 17, 1),
(22, '信息咨询部', '信息部', 3, 21, 1),
(23, '音乐表演', '表演', 4, 19, 1);

-- --------------------------------------------------------

--
-- 表的结构 `bysj_mission_list`
--

CREATE TABLE IF NOT EXISTS `bysj_mission_list` (
  `mission_id` int(4) NOT NULL AUTO_INCREMENT COMMENT '任务id',
  `name` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '任务名称',
  `address` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '保存地址',
  `filename1` varchar(40) CHARACTER SET gb2312 NOT NULL COMMENT '设计类参考',
  `filename2` varchar(40) CHARACTER SET gb2312 NOT NULL COMMENT '论文类参考',
  `uploader` tinyint(1) NOT NULL COMMENT '上传者',
  `demonstration` mediumtext CHARACTER SET gb2312 COMMENT '文档说明',
  `start_time` int(11) NOT NULL COMMENT '任务开始时间',
  `end_time` int(11) NOT NULL COMMENT '任务截止时间',
  `print_time` int(11) NOT NULL COMMENT '打印时间',
  `paper_type` varchar(6) CHARACTER SET gb2312 NOT NULL COMMENT '纸型',
  `paper_num` smallint(3) NOT NULL COMMENT '份数',
  `year` varchar(8) CHARACTER SET gb2312 NOT NULL DEFAULT '2010' COMMENT '年度',
  `pro_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '所属专业',
  `lockit` tinyint(4) NOT NULL DEFAULT '0' COMMENT '文档锁定',
  `needdoc` tinyint(4) NOT NULL DEFAULT '0' COMMENT '必需文档标记',
  PRIMARY KEY (`mission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=141 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_mission_log`
--

CREATE TABLE IF NOT EXISTS `bysj_mission_log` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mission_id` tinyint(2) NOT NULL COMMENT '任务id',
  `teacher_id` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '教师帐号',
  `student_id` varchar(12) CHARACTER SET gb2312 NOT NULL COMMENT '学生帐号',
  `first_upload` date NOT NULL COMMENT '初次上传时间',
  `is_check` tinyint(1) NOT NULL COMMENT '审核',
  `check_suggestion` mediumtext CHARACTER SET gb2312 COMMENT '审核意见',
  `teacher_suggestion` mediumtext CHARACTER SET gb2312 COMMENT '教师意见',
  `student_suggestion` mediumtext CHARACTER SET gb2312 COMMENT '学生意见',
  `last_uploadtime` date NOT NULL COMMENT '最新上传时间',
  `upload_times` tinyint(2) NOT NULL COMMENT '上传次数',
  `lock_flag` tinyint(1) NOT NULL COMMENT '锁定标记',
  `teacher_firstwatch` date DEFAULT NULL COMMENT '教师初次浏览时间',
  `teacher_lastwatch` date DEFAULT NULL COMMENT '教师最近浏览时间',
  `student_firstwatch` date DEFAULT NULL COMMENT '学生初次浏览时间',
  `student_lastwatch` date DEFAULT NULL COMMENT '学生最近浏览时间',
  `filename` varchar(40) CHARACTER SET gb2312 NOT NULL DEFAULT '文档名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=5275 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_ok_topic`
--

CREATE TABLE IF NOT EXISTS `bysj_ok_topic` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `topic` varchar(40) CHARACTER SET gb2312 NOT NULL COMMENT '设计题目',
  `type` varchar(16) CHARACTER SET gb2312 NOT NULL COMMENT '课题类型',
  `source` varchar(30) CHARACTER SET gb2312 NOT NULL DEFAULT '自拟课题' COMMENT '题目来源',
  `student_id` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '学生ID',
  `teacher_id` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '指导教师ID',
  `teacher2_id` varchar(20) CHARACTER SET gb2312 DEFAULT NULL COMMENT '评阅教师ID',
  `teacher_name` varchar(10) CHARACTER SET gb2312 NOT NULL COMMENT '指导教师名字',
  `techpos` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '指导教师职称',
  `pyfilename` varchar(40) CHARACTER SET gb2312 NOT NULL COMMENT '评阅反馈',
  `student_pro_id` tinyint(4) NOT NULL COMMENT '学生专业',
  `spmissionid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '送评论文',
  `difficulty` varchar(10) CHARACTER SET gb2312 NOT NULL DEFAULT '适中' COMMENT '题目难度',
  `count1` int(4) NOT NULL DEFAULT '0' COMMENT '论文字数',
  `count2` int(4) NOT NULL DEFAULT '0' COMMENT '译文字数',
  `new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '题目新旧',
  `comment1` varchar(500) CHARACTER SET gb2312 DEFAULT NULL COMMENT '指导意见',
  `comment2` varchar(500) CHARACTER SET gb2312 DEFAULT NULL COMMENT '评阅意见',
  `comment3` varchar(500) CHARACTER SET gb2312 DEFAULT NULL COMMENT '考核意见',
  `comment4` varchar(500) CHARACTER SET gb2312 DEFAULT NULL COMMENT '综合意见',
  `score1_1` float NOT NULL DEFAULT '0' COMMENT '指导分1',
  `score1_2` float NOT NULL DEFAULT '0' COMMENT '指导分2',
  `score1_3` float NOT NULL DEFAULT '0' COMMENT '指导分3',
  `score2_1` float NOT NULL DEFAULT '0' COMMENT '评阅分1',
  `score2_2` float NOT NULL DEFAULT '0' COMMENT '评阅分2',
  `score2_3` float NOT NULL DEFAULT '0' COMMENT '评阅分3',
  `score3_1` float NOT NULL DEFAULT '0' COMMENT '答辩分1',
  `score3_2` float NOT NULL DEFAULT '0' COMMENT '答辩分2',
  `score3_3` float NOT NULL DEFAULT '0' COMMENT '答辩分3',
  `score3_4` float NOT NULL DEFAULT '0' COMMENT '答辩分4',
  `supplement` int(4) NOT NULL DEFAULT '0' COMMENT '补充信息',
  `fenzu` varchar(8) CHARACTER SET gb2312 NOT NULL DEFAULT '2010A' COMMENT '答辩分组',
  `sequence` tinyint(4) NOT NULL DEFAULT '0' COMMENT '答辩次序',
  `year` varchar(4) CHARACTER SET gb2312 NOT NULL DEFAULT '2010' COMMENT '毕业届',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=468 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_set_date`
--

CREATE TABLE IF NOT EXISTS `bysj_set_date` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `pro_id` tinyint(4) NOT NULL COMMENT '所属专业',
  `topic_start` int(11) NOT NULL COMMENT '教师提交时间',
  `topic_end` int(11) NOT NULL COMMENT '教师截止时间',
  `student_start` int(11) NOT NULL COMMENT '学生选题时间',
  `student_end` int(11) NOT NULL COMMENT '学生截止时间',
  `teacher_start` int(11) NOT NULL COMMENT '选学生开始时间',
  `teacher_end` int(11) NOT NULL COMMENT '选学生结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_student_select`
--

CREATE TABLE IF NOT EXISTS `bysj_student_select` (
  `number` varchar(11) NOT NULL COMMENT '学号',
  `topic_num` smallint(4) NOT NULL COMMENT '题号',
  `wish` varchar(4) NOT NULL COMMENT '志愿',
  `pro_id` tinyint(4) NOT NULL COMMENT '学生专业'
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_student_sheet`
--

CREATE TABLE IF NOT EXISTS `bysj_student_sheet` (
  `profession` varchar(40) NOT NULL COMMENT '专业',
  `class` varchar(40) NOT NULL COMMENT '班级',
  `number` varchar(11) NOT NULL COMMENT '学号',
  `name` varchar(10) NOT NULL COMMENT '姓名',
  `password` varchar(30) NOT NULL COMMENT '密码',
  `authority` tinyint(4) NOT NULL DEFAULT '0' COMMENT '权限',
  `dorm` varchar(40) NOT NULL COMMENT '宿舍',
  `phone` varchar(20) NOT NULL COMMENT '联系电话',
  `mobilephone` varchar(20) NOT NULL COMMENT '手机',
  `short_number` varchar(10) NOT NULL COMMENT '短号',
  `qq_number` varchar(15) NOT NULL COMMENT 'qq号',
  `email` varchar(40) NOT NULL COMMENT '电子邮箱',
  `year` varchar(20) NOT NULL COMMENT '分组',
  `chengji` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成绩评价',
  `aihao` varchar(30) NOT NULL DEFAULT '无' COMMENT '兴趣方向',
  `tmptime` int(11) NOT NULL DEFAULT '0' COMMENT '临时上传'
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

--
-- 转存表中的数据 `bysj_student_sheet`
--

INSERT INTO `bysj_student_sheet` (`profession`, `class`, `number`, `name`, `password`, `authority`, `dorm`, `phone`, `mobilephone`, `short_number`, `qq_number`, `email`, `year`, `chengji`, `aihao`, `tmptime`) VALUES
('音乐学', '音乐12-2班', '12104880201', '包玉繁', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880202', '柴慧琳', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880203', '柴依琳', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880204', '陈芳', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880205', '邓莹莹', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880206', '杜梦瑶', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880207', '谷雪婷', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880209', '黄皓恩', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880210', '黄瑞茵', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880212', '梁可盈', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880214', '龙萦忻', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880215', '聂丽华', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880216', '彭浠洋', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880217', '余晓慈', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880218', '余掌珠', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880220', '张培瑶', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880221', '庄心湄', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880222', '邹云芳', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880223', '曹智鸿', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880224', '李万祥', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880225', '梁健欢', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880226', '廖启文', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880227', '伦国豪', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880228', '彭成', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐12-2班', '12104880229', '向智', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020101', '蔡旭红', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020102', '陈春燕', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020103', '陈芳', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020104', '邓梦蕾', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020105', '冯贞', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020106', '何迎风', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020107', '黄海冰', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020108', '黄虹', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020109', '黄华燕', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020110', '景雅馨', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020111', '李凤', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020112', '李倩玉', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020113', '梁丁尹', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020114', '梁恩兰', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020115', '梁议尹', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020116', '林焕东', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020117', '林慧', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020118', '林静怡', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020119', '刘付洁丹', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020120', '马如意', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020121', '欧晓君', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020122', '谭万棋', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020123', '王虹丹', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020124', '伍雅慧', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020125', '杨华丽', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020126', '杨茜雅', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020127', '招淑仪', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020128', '郑敏', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020129', '周静雯', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020130', '周卓咏', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020131', '朱丹晓', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020132', '陈亚钦', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020133', '陈允隆', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020134', '崔忠华', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020135', '黎', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020136', '梁猛', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020138', '萧文铭', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020139', '肖锋', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020140', '徐永锋', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020142', '郑万强', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020143', '黄海英', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020144', '陈婷琼', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020145', '陈雅思', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020146', '严琼', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020147', '黄贞棋', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐09-1班', '09104020148', '陈敬霞', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030101', '蔡莹', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030102', '陈淑仪', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030103', '戴柳君', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030104', '傅慧贞', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030105', '江淳', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030106', '姜若若', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030107', '蒋秀丽', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030108', '李凤', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030109', '李立华', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030110', '李佩殷', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030111', '凌宇欣', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030112', '罗秋冰', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030113', '罗玉霞', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030114', '区佩文', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030115', '谭慧敏', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030117', '韦斌', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030118', '邬淑欣', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030119', '薛曦妍', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030120', '于露露', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030121', '张碧溪', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030122', '张晓玲', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030123', '张欣仪', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030124', '张妍', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030125', '赵云婷', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030126', '钟静文', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030127', '钟秋香', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030128', '傅文健', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030129', '高德勤', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030130', '黄俊雄', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030131', '黄栩汕', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030132', '黄羽军', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030133', '李文伟', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030134', '梁根立', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030136', '刘奇财', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030137', '王伦昀', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030138', '吴栩生', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐表演', '表演09-1班', '09104030141', '周钰', '1', 1, '0', '0', '0', '0', '0', '0', '2012', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010101', '陈婷婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010102', '陈晓翠', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010103', '冯嘉宜', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010104', '何妙玲', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010105', '黄演芬', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010106', '黄梓琪', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010107', '李晶', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010108', '李君', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010109', '李舒婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010110', '梁翠婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010111', '梁慧华', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010112', '梁嘉明', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010113', '梁嘉雯', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010114', '梁敏玲', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010115', '梁婷婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010116', '刘卉', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010117', '马丽蔓', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010118', '容惠萍', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010119', '沈晓愉', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010120', '苏敏钏', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010121', '苏婉婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010122', '谭乐彩', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010123', '翁婉萌', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010124', '吴雅婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010125', '吴玉婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010126', '肖妮', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010127', '肖琦', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010128', '徐慕华', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010129', '杨婧', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010131', '尹誉霖', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010132', '曾凌宇', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010133', '张凤萍', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010135', '郑妙媚', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010136', '陈跃彬', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010138', '何晴宇', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010139', '黄家粼', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010140', '蒋凯翔', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010141', '李浩宇', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010143', '杨炳飞', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010144', '郑秋仪', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010145', '刘嘉舜', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010146', '曾西华', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐学', '音乐10-1班', '10104010147', '唐周鹏', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030101', '蔡丽萍', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030103', '陈静', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030104', '丁文婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030105', '丁香', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030106', '冯静静', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030107', '符蓉', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030108', '黄妍', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030109', '黄颖思', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030110', '黄颖欣', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030111', '黄圳霞', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030112', '贾茜', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030114', '李颖诗', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030115', '李媛', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030116', '林子君', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030117', '刘丽', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030118', '罗海艳', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030120', '谭韵', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030121', '田佳', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030122', '吴梦婷', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030123', '于梦雯', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030124', '曾双玲', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030125', '张丽芳', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030126', '张莹莹', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030127', '赵雪', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030128', '钟清菊', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030129', '钟淑华', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030130', '陈天业', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030131', '何国晖', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030132', '何建波', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030133', '蒋涛', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030134', '林浩滔', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030136', '刘竣宇', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030137', '莫永权', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030139', '谢漾', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030140', '尹鹏程', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030141', '于奇', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030142', '张柏祀', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030143', '张嘉文', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030144', '张志豪', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演10-1班', '10104030145', '周福', '1', 1, '0', '0', '0', '0', '0', '0', '2013', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030101', '常韦', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030102', '杜姗姗', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030103', '冯苑婷', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030105', '关嘉瑜', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030107', '林霜梅', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030108', '司徒婷婷', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030109', '谭婉琳', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030110', '王瑞', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030113', '夏晓晓', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030115', '张淑婷', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030116', '张晓璇', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030117', '周凯欣', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030118', '陈家祺', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030119', '韩红战', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030120', '韩远', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030121', '黄刚', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030122', '梁焯基', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030123', '刘锐', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030125', '牛航', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030126', '宋耀华', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030128', '吴晓旭', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030130', '张家满', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演11-1班', '11104030131', '彭首霞', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010101', '邓庆琳', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010102', '冯紫欣', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010103', '关晴', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010104', '郭翠婵', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010105', '胡颖娟', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010106', '柯美萍', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010107', '雷碧瑶', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010108', '李沛英', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010109', '梁青霞', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010110', '刘雅琦', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010111', '刘意', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010112', '卢梦圆', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010113', '罗娜', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010114', '孟凡一', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010115', '欧诗华', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010117', '彭雪莹', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010118', '秦舒', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010119', '万丹丹', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010120', '王婷萱', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010121', '吴君玲', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010122', '谢文意', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010123', '杨海英', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010124', '杨咏茵', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010125', '姚烨婷', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010126', '余卫文', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010127', '岑光辉', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010128', '曾文星', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010130', '戴铮', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010131', '冯伟斌', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010132', '龚魏进', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010133', '胡永华', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010134', '赖一锋', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010135', '梁永明', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010136', '廖尚通', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010137', '欧东生', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010138', '彭海龙', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010139', '伍建强', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010140', '谢爱伦', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010141', '许生准', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010142', '叶健良', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010143', '张志坤', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010144', '赖蕾妃', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010145', '高方瑜', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010146', '谢少珍', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐学', '音乐11-1班', '11104010147', '吴海燕', '1', 1, '0', '0', '0', '0', '0', '0', '2014', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870101', '蔡玉敏', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870102', '黄淑美', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870103', '黄雅瑜', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870104', '刘', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870105', '魏君灵', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870106', '温舒晴', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870107', '徐弋琪', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870108', '张艺骞', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870109', '周佩湘', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870110', '周璇', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870111', '陈鑫贺', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870112', '高立翔', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870113', '李旦', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870114', '刘柱天', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870115', '孙钰轩', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870116', '王利斌', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870117', '杨世鹏', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0),
('音乐表演', '表演12-1班', '12104870118', '赵永强', '1', 1, '0', '0', '0', '0', '0', '0', '2015', 0, '无', 0);

-- --------------------------------------------------------

--
-- 表的结构 `bysj_suggestion`
--

CREATE TABLE IF NOT EXISTS `bysj_suggestion` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `account` varchar(20) CHARACTER SET gb2312 NOT NULL COMMENT '提意见者',
  `advise` text CHARACTER SET gb2312 NOT NULL COMMENT '建议',
  `answer` mediumtext CHARACTER SET gb2312 NOT NULL COMMENT '回复',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- 表的结构 `bysj_teacher_information`
--

CREATE TABLE IF NOT EXISTS `bysj_teacher_information` (
  `teacher_id` varchar(20) NOT NULL COMMENT '教师id',
  `teacher_alias` varchar(20) DEFAULT NULL COMMENT '登录别名',
  `name` varchar(10) NOT NULL COMMENT '姓名',
  `password` varchar(30) NOT NULL COMMENT '密码',
  `open` tinyint(1) NOT NULL COMMENT '开启',
  `authority` tinyint(2) NOT NULL COMMENT '权限',
  `belong` tinyint(4) NOT NULL DEFAULT '12' COMMENT '所属单位',
  `lead_num` varchar(60) NOT NULL COMMENT '指导学生数量',
  `officephone` varchar(20) NOT NULL COMMENT '办公电话',
  `homephone` varchar(20) NOT NULL COMMENT '家庭电话',
  `mobilephone` varchar(15) NOT NULL COMMENT '手机',
  `short_number` varchar(10) NOT NULL COMMENT '短号',
  `qq_number` varchar(15) NOT NULL COMMENT 'qq号',
  `techpos` varchar(20) NOT NULL COMMENT '技术职称',
  `techposdate` varchar(18) NOT NULL COMMENT '聘任日期',
  `officepos` varchar(20) NOT NULL COMMENT '行政职务',
  `sex` varchar(4) NOT NULL COMMENT '性别',
  `birthday` varchar(18) NOT NULL COMMENT '出生日期',
  `hometown` varchar(40) NOT NULL COMMENT '出生地',
  `zhengzhi` varchar(10) NOT NULL COMMENT '政治面貌',
  `minzhu` varchar(10) NOT NULL COMMENT '民族',
  `educatelevel` varchar(10) NOT NULL COMMENT '文化程度',
  `degree` varchar(10) NOT NULL COMMENT '学 位',
  `graduate` varchar(20) NOT NULL COMMENT '毕业时间',
  `graduateschool` varchar(40) NOT NULL COMMENT '毕业学校',
  `profession` varchar(40) NOT NULL COMMENT '所学专业',
  `jobfield` varchar(40) NOT NULL COMMENT '从事专业',
  `email` varchar(40) NOT NULL COMMENT '电子邮件',
  `research` mediumtext NOT NULL COMMENT '研究方向',
  `prise1` varchar(30) NOT NULL COMMENT '奖励种类',
  `prisename1` varchar(40) NOT NULL COMMENT '项目名称',
  `level1` varchar(10) NOT NULL COMMENT '等级',
  `grade1` varchar(10) NOT NULL COMMENT '排名',
  `year1` varchar(10) NOT NULL COMMENT '年度',
  `prise2` varchar(30) NOT NULL COMMENT '奖励种类',
  `prisename2` varchar(40) NOT NULL COMMENT '项目名称',
  `level2` varchar(10) NOT NULL COMMENT '等级',
  `grade2` varchar(10) NOT NULL COMMENT '排名',
  `year2` varchar(10) NOT NULL COMMENT '年度',
  `prise3` varchar(30) NOT NULL COMMENT '奖励种类',
  `prisename3` varchar(40) NOT NULL COMMENT '项目名称',
  `level3` varchar(10) NOT NULL COMMENT '等级',
  `grade3` varchar(10) NOT NULL COMMENT '排名',
  `year3` varchar(10) NOT NULL COMMENT '年度',
  `writing1` varchar(80) NOT NULL COMMENT '著作',
  `publish1` varchar(80) NOT NULL COMMENT '出版社',
  `writing2` varchar(80) NOT NULL COMMENT '著作',
  `publish2` varchar(80) NOT NULL COMMENT '出版社',
  `writing3` varchar(80) NOT NULL COMMENT '著作',
  `publish3` varchar(80) NOT NULL COMMENT '出版社',
  `achieve1` varchar(80) NOT NULL COMMENT '科研成果名称',
  `department1` varchar(80) NOT NULL COMMENT '授予单位',
  `achieve2` varchar(80) NOT NULL COMMENT '科研成果名称',
  `department2` varchar(80) NOT NULL COMMENT '授予单位',
  `achieve3` varchar(80) NOT NULL COMMENT '科研成果名称',
  `department3` varchar(80) NOT NULL COMMENT '授予单位',
  `fenzu` varchar(8) NOT NULL DEFAULT 'none' COMMENT '答辩分组',
  `fenzu2` varchar(8) NOT NULL DEFAULT 'none' COMMENT '专科分组',
  `tmptime` int(11) NOT NULL DEFAULT '0' COMMENT '临时上传',
  PRIMARY KEY (`teacher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

--
-- 转存表中的数据 `bysj_teacher_information`
--

INSERT INTO `bysj_teacher_information` (`teacher_id`, `teacher_alias`, `name`, `password`, `open`, `authority`, `belong`, `lead_num`, `officephone`, `homephone`, `mobilephone`, `short_number`, `qq_number`, `techpos`, `techposdate`, `officepos`, `sex`, `birthday`, `hometown`, `zhengzhi`, `minzhu`, `educatelevel`, `degree`, `graduate`, `graduateschool`, `profession`, `jobfield`, `email`, `research`, `prise1`, `prisename1`, `level1`, `grade1`, `year1`, `prise2`, `prisename2`, `level2`, `grade2`, `year2`, `prise3`, `prisename3`, `level3`, `grade3`, `year3`, `writing1`, `publish1`, `writing2`, `publish2`, `writing3`, `publish3`, `achieve1`, `department1`, `achieve2`, `department2`, `achieve3`, `department3`, `fenzu`, `fenzu2`, `tmptime`) VALUES
('fj902', NULL, '付洁', '1', 1, 90, 19, ',20-4,,23-3,', '', '', '13926730705', '61997', '44612424', '讲师', '2009.09', '教研室主任', '女', '1979.07', '河南省', '群众', '汉', '硕士研究生', '硕士', '2007.07', '中国艺术研究院', '音乐学', '', '44612424@qq.co', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('dj901', NULL, '党劲', '1', 1, 90, 19, ',20-4,,23-3,', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('cgl903', NULL, '陈广林', 't6z6k2e2', 1, 10, 19, ',20-4,,23-3,', '', '', '15016665058', '65058', '582752650', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '582752650@qq.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('cwj904', NULL, '陈伟坚', 'h1d2c1k3', 1, 10, 19, ',20-4,,23-3,', '/', '/', '13709629338', '69338', '952516843', '讲师', '2005.07', '/', '男', '1977.11', '广东茂名', '党员', '汉', '本科', '/', '2001.07', '星海音乐学院', '音乐学（舞蹈方向）', '舞蹈', '952516843（QQ）', '舞蹈编导、舞蹈欣赏、舞蹈形体训练、音乐欣赏', '广东群众音乐舞蹈花会', '歌舞《飞越未来》', '金奖', '', '2005', '广东大学生舞蹈比赛', '舞蹈《校园奋斗曲》', '一等奖', '', '2010', '广东高校反腐倡廉文艺汇演', '舞蹈情景剧《门》', '一等奖', '', '2011', '论普通高校音乐欣赏内容的新发展', '南方论刊', '欣赏、实践、创作一体化', '大学时代', '', '', '编舞――《欢洗》（横向）', '校科研处、茂名十四小', '编舞――《龙的传人》（横向）', '校科研处、高州市人民医院', '', '', 'none', '2010A', 0),
('yxx905', NULL, '杨晓霞', '001225', 1, 10, 19, ',20-4,,23-3,', '', '', '18211509378', '648261', '276973892', '讲师', '2008.06', '教师', '女', '1979.06', '河南许昌', '群众', '汉', '研究生', '硕士', '2006.07', '白俄罗斯国立音乐学院', '声乐表演', '声乐', '276973892@qq.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('zln906', NULL, '赵丽娜', '830210', 1, 10, 19, ',20-4,,23-3,', '', '', '15986230665', '630665', '84542937', '讲师', '2009.08', '', '女', '1983.02', '宁夏', '党员', '满', '研究生', '硕士', '2008.07', '乌克兰卢甘斯克国立大学', '舞蹈', '', '', '舞蹈编导、教育方向', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('mqm907', NULL, '孟庆民', 'g5o4o4o3', 1, 10, 19, ',20-4,,23-3,', '0668-2923342', '', '15119626698', '626698', '', '副教授', '2008.11', '副主任', '男', '1962.11', '河南民权', '中共党员', '汉', '大学本科', '学士', '1988.07', '河南大学音乐系', '二胡，作曲理论', '音乐教育', 'meng.laoshi521@163.com', '歌曲写作、乐队编配、二胡', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('zj908', NULL, '朱静', '00001224', 1, 10, 19, ',20-4,,23-3,', '', '', '15363148380', '', '', '副教授', '2004.12', '', '女', '1963.06', '江苏苏州', '民盟', '汉', '大学', '文学学士', '1986.07', '南京师范大学音乐系', '音乐教育主修小提琴', '', 'QQ2449813792', '学校公共课、艺术系小提琴教学', '广东省文化厅', '歌曲：校园之星', '三等奖', '1', '1995', '广东省文化厅', '歌曲：父亲和母亲', '二等奖', '2', '1995', '中国广播电视学会', '歌曲：荔乡蜜月', '银奖', '2', '1997', '论曹光平教授广东音乐创作的几种意识', '中国音乐2004、1', '粤西单人木偶的艺术研究', '广西民族学院学报2003、8', '年例中寻觅冼太夫人的足迹', '广东艺术2004、1', '适应21世纪发展，需要理工科院', '2002、4-2004、8学院科研处', '的研究', '', '对当代道德建设的道德心理学和伦理社会学的研宄', '2004、1-2005、8学院科研处', 'none', '2010A', 0),
('fl909', NULL, '冯丽', 'fl228967', 1, 10, 19, ',20-4,,23-3,', '', '2102719', '13902517956', '', '', '讲师', '2007.08', '', '女', '1979.11', '河南南阳', '群众', '汉', '硕士', '研究生', '2005.07', '河南大学', '作曲技术理论', '', 'lee.feng@163.COM', '现担任主要课程:曲式与作品分析基础、基础和声学、小提琴演奏。\r\n研究方向：作曲技术理论―和声与曲式学方向研究；\r\n          小提琴演奏与教学研究。', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('cxy910', NULL, '陈晓艳', '11111aaaaa', 1, 10, 19, ',20-4,,23-3,', '', '', '', '', '', '讲师', '2009.08', '', '女', '1981.10', '吉林', '中共党员', '汉', '硕士研究生', '硕士', '2007.07', '东北师范大学音乐学院', '音乐学', '', 'yanzi_forever@163.com', '主要教授钢琴、视唱练耳、音乐美学、世界民族音乐、中外音乐教育比较、西方音乐（理论方向主修课程）等课程。主要研究方向为钢琴教学与演奏、视唱练耳教学法以及西方音乐理论研究。', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', '2010A', 0),
('ty911', '铁云婵', '铁云婵', 'f1m1m9f4', 1, 10, 19, ',20-4,,23-3,', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', 'none', 0),
('hy912', '胡洋', '胡洋', 'n9k4n5t3', 1, 10, 19, ',20-2,,23-2,', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', 'none', 0),
('lcm913', '吕春媚', '吕春媚', 'g6c5g6p4', 1, 10, 19, ',20-2,,23-2,', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'none', 'none', 0);

-- --------------------------------------------------------

--
-- 表的结构 `bysj_title_sort`
--

CREATE TABLE IF NOT EXISTS `bysj_title_sort` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '选题类别id',
  `name` varchar(30) NOT NULL COMMENT '选题类别名称',
  `open` tinyint(1) NOT NULL COMMENT '开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `bysj_title_sort`
--

INSERT INTO `bysj_title_sort` (`id`, `name`, `open`) VALUES
(1, '工程设计', 1),
(2, '软件开发', 1),
(3, '实验室建设', 1),
(4, '课程教学', 1),
(5, '科学研究', 1);

-- --------------------------------------------------------

--
-- 表的结构 `bysj_topic`
--

CREATE TABLE IF NOT EXISTS `bysj_topic` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `teacher_id` varchar(20) NOT NULL COMMENT '教师id',
  `topic` varchar(40) NOT NULL COMMENT '题目',
  `source` tinyint(1) NOT NULL COMMENT '题目来源',
  `student_number` varchar(11) NOT NULL COMMENT '选该题的学生',
  `student_pro_id` tinyint(4) NOT NULL COMMENT '选定学生专业',
  `is_select` tinyint(1) NOT NULL COMMENT '选定',
  `type` tinyint(3) NOT NULL COMMENT '类型',
  `profession` varchar(40) NOT NULL COMMENT '专业',
  `meaning` mediumtext NOT NULL COMMENT '意义',
  `request` mediumtext NOT NULL COMMENT '要求',
  `question` mediumtext NOT NULL COMMENT '问题 ',
  `time` date NOT NULL COMMENT '日期',
  `year` varchar(4) NOT NULL COMMENT '年度',
  `verify` tinyint(4) DEFAULT '0' COMMENT '审核',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=2130 ;

--
-- 转存表中的数据 `bysj_topic`
--

INSERT INTO `bysj_topic` (`id`, `teacher_id`, `topic`, `source`, `student_number`, `student_pro_id`, `is_select`, `type`, `profession`, `meaning`, `request`, `question`, `time`, `year`, `verify`) VALUES
(2103, 'fj902', '测试', 0, '0', 0, 0, 1, '20,23,', '测试', '测试', '1.\r\n2.3\r\n3.', '2013-05-29', '2012', 0),
(2104, 'fj902', '继续测试', 0, '0', 0, 0, 1, '20,23,', '124124', '12414214', '124124', '2013-05-29', '2013', 1),
(2105, 'fj902', '撒打算发', 0, '0', 0, 0, 5, '20,23,', '阿斯打算打阿斯顿', '123124124', '124141', '2013-05-29', '2013', 1),
(2106, 'fj902', '再添加', 0, '09104030103', 23, 1, 4, '20,23,', '2131241', '124124', '1231', '2013-05-29', '2013', 1),
(2107, 'fj902', '1111', 0, '0', 0, 0, 4, '20,23,', '', '', '', '2013-06-01', '2012', 1),
(2108, 'fj902', '112', 0, '0', 0, 0, 2, '20,23,', '43234', '454543', '45544', '2013-06-01', '2013', 1),
(2112, 'dj901', '44', 0, '0', 0, 0, 0, '20,23,', '555555555', '666666666', '888888', '2013-06-01', '2013', 9),
(2111, 'fj902', '12222', 0, '09104030101', 23, 1, 3, '20,23,', '333333', '33332', '2222222222222', '2013-06-01', '2013', 1),
(2113, 'fj902', '45', 0, '0', 0, 0, 0, '20,23,', '5', '444', '5', '2013-06-01', '2013', -1),
(2114, 'fj902', '231212', 0, '0', 0, 0, 6, '20,23,', '21212', '3221213', '323', '2013-06-01', '2013', 1),
(2115, 'fj902', '..........', 0, '0', 0, 0, 0, '20,23,', '123', '.....', '.......', '2013-06-01', '2013', 1),
(2116, 'fj902', '..........', 0, '0', 0, 0, 0, '20,23,', '123', '.....', '.......', '2013-06-01', '2013', 1),
(2117, 'fj902', '231212', 0, '09104030104', 23, 1, 6, '20,23,', '21212', '3221213', '323', '2013-06-01', '2013', 1),
(2118, 'fj902', '231212', 0, '0', 0, 0, 6, '20,23,', '21212', '3221213', '323', '2013-06-01', '2013', 1),
(2119, 'fj902', '231212', 0, '0', 0, 0, 6, '20,23,', '21212', '3221213', '323', '2013-06-01', '2013', 1),
(2120, 'fj902', '222222222', 0, '0', 0, 0, 6, '20,23,', '222222222', '222222222', '22222222', '2013-06-01', '2013', 1),
(2121, 'dj901', 'hhhhhhh', 0, '0', 0, 0, 6, ',,', 'hhhhhhhhh', 'hhhhhhhh', 'hhhhhh', '2013-06-01', '2013', 0),
(2122, 'dj901', 'hhhhh', 0, '0', 0, 0, 0, '20,23,', 'hhhhhhhhh', 'hhhhhhhhh', 'hhhhhhhhhh', '2013-06-01', '2013', 1),
(2123, 'fj902', 'dj', 0, '0', 0, 0, 6, '20,23,', '444444444554', '56666', '654', '2013-06-01', '2013', 1),
(2124, 'dj901', '11111111111111', 0, '0', 0, 0, 6, '20,23,', '2222222222', '2222222', '222222222', '2013-06-01', '2013', 1),
(2125, 'dj901', 'rj', 0, '0', 0, 0, 6, '20,23,', '44444', '3333333', '44444', '2013-06-01', '2013', 1),
(2126, 'fj902', 'kkkkkkkkkk', 0, '0', 0, 0, 5, '20,23,', 'jkkkkkkkkkk', 'jhhhhhhhhhh', 'kkkkkkkkk', '2013-06-01', '2013', 1),
(2127, 'fj902', 'nnnnn', 0, '0', 0, 0, 1, '20,23,', 'nnnnnnnnnn', 'nnnnn', 'nnnnnnnn', '2013-06-01', '2013', 1),
(2128, 'fj902', 'mmmmmmmm', 0, '0', 0, 0, 1, '20,23,', 'mmmmmmmmmmm', 'mmmmmmmmmmmmm', 'mmmmmmmmmmmm', '2013-06-01', '2013', 1),
(2129, 'fj902', '........', 0, '0', 0, 0, 4, '20,23,', '.........................', '........', '......', '2013-06-01', '2013', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
