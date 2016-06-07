# Host: localhost  (Version: 5.6.29)
# Date: 2016-06-07 17:57:33
# Generator: MySQL-Front 5.3  (Build 5.17)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "privilege"
#

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` varchar(255) DEFAULT NULL COMMENT '父权限id',
  `privilege_name` varchar(255) DEFAULT NULL COMMENT '权限名字',
  `privilege_desc` varchar(255) DEFAULT NULL COMMENT '权限描述',
  `class` int(11) DEFAULT NULL COMMENT '权限类别 1.表示应用，2表示菜单，3表示按钮',
  `sort` int(11) DEFAULT NULL COMMENT '各级的排列顺序',
  `click` tinyint(3) DEFAULT '1' COMMENT '是否是url; 0 表示url, 1 表示不是',
  `show_index` tinyint(3) DEFAULT '1' COMMENT '是否在首页显示： 1是，0,不是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='权限表';

#
# Data for table "privilege"
#

INSERT INTO `privilege` VALUES (1,'0','Home','Home模块',1,1,1,1),(2,'0','Admin','管理模块',1,1,1,1),(3,'1','Home/ModelManager','权限管理模块',2,1,1,1),(4,'3','Home/ModelManager/add','添加权限',3,1,0,1),(5,'3','Home/ModelManager/index','权限列表',3,1,0,1),(6,'1','Home/RoleManager','角色模块',2,1,1,1),(7,'6','Home/RoleManager/add','添加角色',3,1,0,1),(8,'6','Home/RoleManager/index','角色列表',3,1,0,1),(9,'1','Home/UserManager','用户模块',2,1,1,1),(10,'9','Home/UserManager/add','添加用户',3,1,0,1),(11,'9','Home/UserManager/index','用户列表',3,1,0,1),(12,'6','Home/RoleManager/update','更新角色',3,1,0,0),(13,'2','Admin/Index','后台首页控制器',2,1,1,1),(14,'13','Admin/Index/index','首页',3,1,1,1),(15,'14','Admin/Index/index/indexChild','测试四级目录',4,1,0,1),(16,'15','Admin/Index/index/indexChild/hello','hhhh',5,11,0,1),(17,'5','Home/ModelManager/index/index','额外测试的',4,1,0,1);

#
# Structure for table "role"
#

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) DEFAULT NULL COMMENT '角色名',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `gen_time` date DEFAULT NULL,
  `status` varchar(255) DEFAULT '1' COMMENT '是否启用0表示启用，1表示锁定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='角色';

#
# Data for table "role"
#

INSERT INTO `role` VALUES (1,'admin','管理员','2016-04-21','0'),(2,'anyone','游客','2016-04-21','0'),(3,'test1','实验账号1','2016-04-22','0'),(4,'test2','实验账号2','2016-04-22','0'),(5,'','','2016-06-06','1');

#
# Structure for table "role_privilege"
#

DROP TABLE IF EXISTS `role_privilege`;
CREATE TABLE `role_privilege` (
  `privilege_id` varchar(255) DEFAULT NULL COMMENT '权限id',
  `role_id` varchar(255) DEFAULT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联';

#
# Data for table "role_privilege"
#

INSERT INTO `role_privilege` VALUES ('4','4'),('5','4'),('14','4'),('4','1'),('5','1'),('7','1'),('8','1'),('10','1'),('11','1'),('14','1'),('4','3'),('5','3'),('7','3'),('10','3'),('4','2'),('5','2'),('7','2'),('8','2'),('10','2'),('11','2');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL,
  `deleted` tinyint(3) DEFAULT '0' COMMENT '0--表示未删除，1--代表删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'root','123456',0),(2,'test','123456',0);

#
# Structure for table "user_role"
#

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `user_id` varchar(255) DEFAULT NULL COMMENT '用户id',
  `role_id` varchar(255) DEFAULT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色关联';

#
# Data for table "user_role"
#

INSERT INTO `user_role` VALUES ('1','1'),('1','2'),('1','3'),('1','4'),('2','2'),('2','3'),('2','4');

#
# Structure for table "view_privilege"
#

DROP VIEW IF EXISTS `view_privilege`;
CREATE VIEW `view_privilege` AS 
  select distinct `user`.`id` AS `user_id`,`id` AS `id`,`parent_id` AS `parent_id`,`privilege_name` AS `privilege_name`,`privilege_desc` AS `privilege_desc`,`class` AS `class`,`sort` AS `sort` from ((((`user` join `user_role`) join `role`) join `role_privilege`) join `privilege`) where ((`user`.`id` = `user_role`.`user_id`) and (`role`.`id` = `user_role`.`role_id`) and (`role`.`status` = 0) and (`role`.`id` = `role_privilege`.`role_id`) and (`role_privilege`.`privilege_id` = `id`));
