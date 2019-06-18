/*
 Navicat Premium Data Transfer

 Source Server         : one
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3306
 Source Schema         : phpems

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 18/06/2019 21:23:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码',
  `truename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '建立时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', '12345678', '管理员', '', '', '', '2019-06-11 23:23:26');

-- ----------------------------
-- Table structure for stu_paper
-- ----------------------------
DROP TABLE IF EXISTS `stu_paper`;
CREATE TABLE `stu_paper`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_ID` int(10) NOT NULL COMMENT '学生id',
  `paper_ID` int(10) NOT NULL COMMENT '试卷id',
  `score` int(3) NOT NULL COMMENT '分数',
  `answer` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '答案对比',
  `time` datetime(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of stu_paper
-- ----------------------------
INSERT INTO `stu_paper` VALUES (4, 7, 30, 5, '{\"radio\":[{\"id\":\"38\",\"answer\":\"B\",\"true_or_false\":\"true\",\"score\":5,\"true_answer\":\"B\",\"analysis\":\"\\u6307\\u4ee4\\u548c\\u6570\\u636e\\u5747\\u5b58\\u653e\\u5728\\u5185\\u5b58\\u4e2d\\uff0c\\u901a\\u5e38\\u7531 PC(\\u7a0b\\u5e8f\\u8ba1\\u6570\\u5668)\\u63d0\\u4f9b\\u5b58\\u50a8\\u5355\\u5143\\u5730\\u5740\\u53d6\\u51fa\\u7684\\u662f\\u6307\\u4ee4\\uff0c\\u7531\\u6307\\u4ee4\\u5730\\u5740\\u7801\\u90e8\\u5206\\u63d0\\u4f9b\\u5b58\\u50a8\\u5355\\u5143\\u5730\\u5740\\u53d6\\u51fa\\u7684\\u662f\\u6570\\u636e\\u3002\\u56e0\\u6b64\\u901a\\u8fc7\\u4e0d\\u540c\\u7684\\u5bfb\\u5740\\u65b9\\u5f0f\\u6765\\u533a\\u522b\\u6307\\u4ee4\\u548c\\u6570\\u636e\\u3002\"},{\"id\":\"39\",\"answer\":\"B\",\"true_or_false\":\"false\",\"score\":5,\"true_answer\":\"C\",\"analysis\":\"PC\\uff08\\u7a0b\\u5e8f\\u8ba1\\u6570\\u5668\\uff09\\u662f\\u7528\\u4e8e\\u5b58\\u653e\\u4e0b\\u4e00\\u6761\\u6307\\u4ee4\\u6240\\u5728\\u5355\\u5143\\u7684\\u5730\\u5740\\u3002\\u5f53\\u6267\\u884c\\u4e00\\u6761\\u6307\\u4ee4\\u65f6\\uff0c\\u5904\\u7406\\u5668\\u9996\\u5148\\u9700\\u8981\\u4ece PC \\u4e2d\\u53d6\\u51fa\\u6307\\u4ee4\\u5728\\u5185\\u5b58\\u4e2d\\u7684\\u5730\\u5740\\uff0c\\u901a\\u8fc7\\u5730\\u5740\\u603b\\u7ebf\\u5bfb\\u5740\\u83b7\\u53d6\\u3002\"},{\"id\":\"40\",\"answer\":\"B\",\"true_or_false\":\"false\",\"score\":5,\"true_answer\":\"C\",\"analysis\":\"\\u6ee1\\u8db3\\u5173\\u7cfb 2K>=K+n+1\\uff0c\\u5f53 n=16 \\u65f6\\uff0cK \\u53d6 5\"},{\"id\":\"41\",\"answer\":\"B\",\"true_or_false\":\"false\",\"score\":5,\"true_answer\":\"D\",\"analysis\":\"\\u5047\\u8bbe\\u6267\\u884c n \\u6761\\u6307\\u4ee4\\uff0c\\u4f7f\\u7528\\u6d41\\u6c34\\u65f6\\u95f4\\u6700\\u957f\\u7684\\u4e58\\u4ee5 n-1\\uff0c\\u518d\\u52a0\\u4e0a\\u4e00\\u6761\\u6307\\u4ee4\\u7684\\u6267\\u884c\\u65f6\\u95f4\\uff0c\\u5373\\uff08100-1\\uff09*4\\u25b3t +\\uff084\\u25b3t + 2\\u25b3t + 3\\u25b3t\\uff09=396\\u25b3t + 9\\u25b3t = 405\\u25b3t\"},{\"id\":\"42\",\"answer\":\"C\",\"true_or_false\":\"false\",\"score\":5,\"true_answer\":\"D\",\"analysis\":\"\\u7531\\u4e8e Cache \\u6bd4\\u4e3b\\u5b58\\u5c0f\\u7684\\u591a\\uff0c\\u56e0\\u6b64\\u5fc5\\u987b\\u4f7f\\u7528\\u4e00\\u79cd\\u673a\\u5236\\u5c06\\u4e3b\\u5b58\\u5730\\u5740\\u5b9a\\u4f4d\\u5230 Cache \\u4e2d\\uff0c\\u5373\\u5730\\u5740\\u6620\\u5c04\\u3002\\u8fd9\\u4e2a\\u6620\\u5c04\\u8fc7\\u7a0b\\u5168\\u90e8\\u7531\\u786c\\u4ef6\\u5b9e\\u73b0\\u3002\"}],\"multiple\":[],\"judge\":[]}', '2019-06-12 09:34:59');
INSERT INTO `stu_paper` VALUES (5, 7, 31, 12, '{\"radio\":[{\"id\":\"43\",\"answer\":\"C\",\"true_or_false\":\"true\",\"score\":6,\"true_answer\":\"C\",\"analysis\":\"\\u65e0\"},{\"id\":\"44\",\"answer\":\"D\",\"true_or_false\":\"false\",\"score\":6,\"true_answer\":\"B\",\"analysis\":\"\\u65e0\"},{\"id\":\"45\",\"answer\":\"C\",\"true_or_false\":\"false\",\"score\":6,\"true_answer\":\"D\",\"analysis\":\"\\u5728\\u540c\\u4e00\\u5929\\uff0c\\u4e24\\u4e2a\\u4e0d\\u540c\\u7684\\u4eba\\u5c31\\u540c\\u6837\\u7684\\u53d1\\u660e\\u521b\\u9020\\u7533\\u8bf7\\u4e13\\u5229\\u7684\\uff0c\\u4e13\\u5229\\u5c40\\u5c06\\u5206\\u522b\\u5411\\u5404\\u7533\\u8bf7\\u4eba\\u901a\\u62a5\\u6709\\u5173\\u60c5\\u51b5\\uff0c\\u8bf7\\u4ed6\\u4eec\\u81ea\\u5df1\\u53bb\\u534f\\u5546\\u89e3\\u51b3\\u8fd9\\u4e00\\u95ee\\u9898\"},{\"id\":\"46\",\"answer\":\"B\",\"true_or_false\":\"true\",\"score\":6,\"true_answer\":\"B\",\"analysis\":\"\\u65e0\"},{\"id\":\"47\",\"answer\":\"B\",\"true_or_false\":\"false\",\"score\":6,\"true_answer\":\"D\",\"analysis\":\"\\u65e0\"}],\"multiple\":[],\"judge\":[]}', '2019-06-12 09:38:23');

-- ----------------------------
-- Table structure for stu_ques
-- ----------------------------
DROP TABLE IF EXISTS `stu_ques`;
CREATE TABLE `stu_ques`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_ID` int(10) NOT NULL COMMENT '学生id',
  `ques_ID` int(10) NOT NULL COMMENT '试题id',
  `paper_ID` int(11) NOT NULL COMMENT '试卷id',
  `stu_answer` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生答案',
  `true_answer` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确答案',
  `time` datetime(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of stu_ques
-- ----------------------------
INSERT INTO `stu_ques` VALUES (16, 7, 38, 30, 'B', 'B', '2019-06-12 09:34:59');
INSERT INTO `stu_ques` VALUES (17, 7, 39, 30, 'B', 'C', '2019-06-12 09:34:59');
INSERT INTO `stu_ques` VALUES (18, 7, 40, 30, 'B', 'C', '2019-06-12 09:34:59');
INSERT INTO `stu_ques` VALUES (19, 7, 41, 30, 'B', 'D', '2019-06-12 09:34:59');
INSERT INTO `stu_ques` VALUES (20, 7, 42, 30, 'C', 'D', '2019-06-12 09:34:59');
INSERT INTO `stu_ques` VALUES (21, 7, 43, 31, 'C', 'C', '2019-06-12 09:38:23');
INSERT INTO `stu_ques` VALUES (22, 7, 44, 31, 'D', 'B', '2019-06-12 09:38:23');
INSERT INTO `stu_ques` VALUES (23, 7, 45, 31, 'C', 'D', '2019-06-12 09:38:23');
INSERT INTO `stu_ques` VALUES (24, 7, 46, 31, 'B', 'B', '2019-06-12 09:38:23');
INSERT INTO `stu_ques` VALUES (25, 7, 47, 31, 'B', 'D', '2019-06-12 09:38:23');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `student_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生用户名',
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生用户密码',
  `time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '建立时间',
  PRIMARY KEY (`student_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES (7, 'student1', '12345678', '2019-06-11 23:11:36');

-- ----------------------------
-- Table structure for student_info
-- ----------------------------
DROP TABLE IF EXISTS `student_info`;
CREATE TABLE `student_info`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `student_id` int(255) NOT NULL COMMENT '学生id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `truename` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '学生姓名',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of student_info
-- ----------------------------
INSERT INTO `student_info` VALUES (6, 7, 'student1', '', '', '', '');

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '科目id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '科目名',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES (1, '计算机');
INSERT INTO `subject` VALUES (5, '数学');
INSERT INTO `subject` VALUES (6, '英语');
INSERT INTO `subject` VALUES (7, '语文');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher`  (
  `teacher_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '教师用户id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师用户名',
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师用户密码',
  `time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '建立时间',
  PRIMARY KEY (`teacher_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES (9, 'teacher2', '12345678', '2019-06-11 23:39:02');

-- ----------------------------
-- Table structure for teacher_info
-- ----------------------------
DROP TABLE IF EXISTS `teacher_info`;
CREATE TABLE `teacher_info`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `teacher_id` int(10) NOT NULL COMMENT '教师用户id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师用户名',
  `subject_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '科目id',
  `truename` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '教师姓名',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of teacher_info
-- ----------------------------
INSERT INTO `teacher_info` VALUES (8, 9, 'teacher2', '1', '', '', '', '');

-- ----------------------------
-- Table structure for test_paper
-- ----------------------------
DROP TABLE IF EXISTS `test_paper`;
CREATE TABLE `test_paper`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '试卷id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `subject_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '科目id',
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '试卷介绍',
  `radio` tinyint(2) NOT NULL COMMENT '单选题数量',
  `multiple` tinyint(2) NOT NULL COMMENT '多选题数量',
  `judgement` tinyint(2) NOT NULL COMMENT '判断题数量',
  `duration` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '试卷考试用时',
  `total_score` tinyint(3) NOT NULL COMMENT '试卷总分',
  `time` datetime(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '建立时间',
  `from_admin` enum('t','f') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '来自管理员',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of test_paper
-- ----------------------------
INSERT INTO `test_paper` VALUES (30, 1, '1', '2016 下半年软件设计师上午真题', '这是软件设计师试卷，只有五道题', 5, 0, 0, '10', 25, '2019-06-11 23:34:56', 't');
INSERT INTO `test_paper` VALUES (31, 9, '1', '5道2016软件设计师试题', '5道', 5, 0, 0, '20', 30, '2019-06-12 08:53:38', 'f');

-- ----------------------------
-- Table structure for test_questions
-- ----------------------------
DROP TABLE IF EXISTS `test_questions`;
CREATE TABLE `test_questions`  (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '试题ID',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题型',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题目内容',
  `time` datetime(0) NOT NULL COMMENT '时间',
  `true_answer` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确答案',
  `score` tinyint(2) NOT NULL COMMENT '试题分数',
  `user_ID` int(10) NULL DEFAULT NULL COMMENT '创建此题的用户id',
  `paper_ID` int(10) NULL DEFAULT NULL COMMENT '试卷id',
  `paper_order` tinyint(2) NULL DEFAULT NULL COMMENT '试卷内题号',
  `a` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '答案A',
  `b` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '答案B',
  `c` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '答案C',
  `d` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '答案D',
  `subject_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '科目id',
  `analysis` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '解析',
  `admin` enum('t','f') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '是否管理员添加',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of test_questions
-- ----------------------------
INSERT INTO `test_questions` VALUES (38, '单选题', '在程序运行过程中，CPU 需要将指令从内存中取出并加以分析和执行。CPU 依据（ ）来区分在内存中以二进制编码形式存放的指令和数据。', '2019-06-11 23:34:56', 'B', 5, 1, 30, 1, '指令周期的不同阶段', '指令和数据的寻址方式', '指令操作码的译码结果', '指令和数据所在的存储单元', '1', '指令和数据均存放在内存中，通常由 PC(程序计数器)提供存储单元地址取出的是指令，由指令地址码部分提供存储单元地址取出的是数据。因此通过不同的寻址方式来区别指令和数据。', 't');
INSERT INTO `test_questions` VALUES (39, '单选题', '计算机在一个指令周期的过程中，为从内存读取指令操作码，首先要将（ ）的内容送到地址总线上。', '2019-06-11 23:34:56', 'C', 5, 1, 30, 2, '指令寄存器（IR）', '通用寄存器（GR）', '程序计数器（PC）', '状态寄存器（PSW）', '1', 'PC（程序计数器）是用于存放下一条指令所在单元的地址。当执行一条指令时，处理器首先需要从 PC 中取出指令在内存中的地址，通过地址总线寻址获取。', 't');
INSERT INTO `test_questions` VALUES (40, '单选题', '已知数据信息为 16 位，最少应附加（ ）位校验位，以实现海明码纠错。', '2019-06-11 23:34:56', 'C', 5, 1, 30, 3, '3', '4', '5', '6', '1', '满足关系 2K>=K+n+1，当 n=16 时，K 取 5', 't');
INSERT INTO `test_questions` VALUES (41, '单选题', '将一条指令的执行过程分解为取指、分析和执行三步，按照流水方式执行，若取指时间t 取指=4△t、分析时间 t 分析=2△t、执行时间 t 执行=3△t，则执行完 100 条指令，需要的时间为（ ）△t。', '2019-06-11 23:34:56', 'D', 5, 1, 30, 4, '200', '300', '400', '405', '1', '假设执行 n 条指令，使用流水时间最长的乘以 n-1，再加上一条指令的执行时间，即（100-1）*4△t +（4△t + 2△t + 3△t）=396△t + 9△t = 405△t', 't');
INSERT INTO `test_questions` VALUES (42, '单选题', '以下关于 Cache 与主存间地址映射的叙述中，正确的是（）', '2019-06-11 23:34:56', 'D', 5, 1, 30, 5, '操作系统负责管理 Cache 与主存之间的地址映射', '程序员需要通过编程来处理 Cache 与主存之间的地址映射', '应用软件对 Cache 与主存之间的地址映射进行调度', '由硬件自动完成 Cache 与主存之间的地址映射', '1', '由于 Cache 比主存小的多，因此必须使用一种机制将主存地址定位到 Cache 中，即地址映射。这个映射过程全部由硬件实现。', 't');
INSERT INTO `test_questions` VALUES (43, '单选题', '在网络设计和实施过程中要采取多种安全措施，其中（ ）是针对系统安全需求的措施。', '2019-06-12 08:53:38', 'C', 6, 9, 31, 1, '设备防雷击', '入侵检测', '漏洞发现与补丁管理', '流量控制', '1', '无', 'f');
INSERT INTO `test_questions` VALUES (44, '单选题', '（ ）的保护期限是可以延长的。', '2019-06-12 08:53:38', 'B', 6, 9, 31, 2, '专利权', '商标权', '著作权', '商业秘密权', '1', '无', 'f');
INSERT INTO `test_questions` VALUES (45, '单选题', '甲公司软件设计师完成了一项涉及计算机程序的发明。之后，乙公司软件设计师也完成了与甲公司软件设计师相同的涉及计算机程序的发明。甲、乙公司于同一天向专利局申请发明专利。此情形下，（ ）是专利权申请人。', '2019-06-12 08:53:38', 'D', 6, 9, 31, 3, '甲公司', '甲、乙两公司', '乙公司', '由甲、乙公司协商确定的公司', '1', '在同一天，两个不同的人就同样的发明创造申请专利的，专利局将分别向各申请人通报有关情况，请他们自己去协商解决这一问题', 'f');
INSERT INTO `test_questions` VALUES (46, '单选题', '甲、乙两厂生产的产品类似，且产品都使用“B”商标。两厂于同一天向商标局申请商标注册，且申请注册前两厂均未使用“B”商标。此情形下，（ ）能核准注册。', '2019-06-12 08:53:38', 'B', 6, 9, 31, 4, '甲厂', '由甲、乙厂抽签确定的厂', '乙厂', '甲、乙两厂', '1', '无', 'f');
INSERT INTO `test_questions` VALUES (47, '单选题', '结构化开发方法中，（ ）主要包含对数据结构和算法的设计。', '2019-06-12 08:53:38', 'D', 6, 9, 31, 5, '体系结构设计', '数据设计', '接口设计', '过程设计', '1', '无', 'f');

SET FOREIGN_KEY_CHECKS = 1;
