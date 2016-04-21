# Host: localhost  (Version: 5.6.29)
# Date: 2016-04-21 21:55:00
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

#
# Data for table "privilege"
#

INSERT INTO `privilege` VALUES (1,'0','Home','Home模块',1,1),(2,'0','Admin','管理模块',1,1),(3,'1','Home/Modelmanager','权限管理模块',2,1),(4,'3','Home/Modelmanager/add','添加权限',3,1),(5,'3','Home/Modelmanager/index','权限列表',3,1),(6,'1','Home/RoleManager','角色模块',2,1),(7,'6','Home/RoleManager/add','添加角色',3,1),(8,'6','Home/RoleManager/index','角色列表',3,1),(9,'1','Home/UserManager','用户模块',2,1),(10,'9','Home/UserManager/add','添加用户',3,1),(11,'9','Home/UserManager/index','用户列表',3,1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';

#
# Data for table "role"
#

INSERT INTO `role` VALUES (1,'admin','管理员','2016-04-21','0'),(2,'anyone','游客','2016-04-21','0');

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

INSERT INTO `role_privilege` VALUES ('4','1'),('5','1'),('7','1'),('8','1'),('10','1'),('11','1'),('10','2'),('11','2');

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'root',NULL),(2,'test',NULL);

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

INSERT INTO `user_role` VALUES ('1','1'),('1','2'),('2','2');

#
# Structure for table "view_privilege"
#

DROP VIEW IF EXISTS `view_privilege`;
CREATE VIEW `view_privilege` AS 
  select distinct `user`.`id` AS `user_id`,`id` AS `id`,`parent_id` AS `parent_id`,`privilege_name` AS `privilege_name`,`privilege_desc` AS `privilege_desc`,`class` AS `class`,`sort` AS `sort` from ((((`user` join `user_role`) join `role`) join `role_privilege`) join `privilege`) where ((`user`.`id` = `user_role`.`user_id`) and (`role`.`id` = `user_role`.`role_id`) and (`role`.`status` = 0) and (`role`.`id` = `role_privilege`.`role_id`) and (`role_privilege`.`privilege_id` = `id`));
