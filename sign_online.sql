-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2018-12-01 21:41:38
-- 服务器版本： 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sign_online`
--

-- --------------------------------------------------------

--
-- 表的结构 `so_admin_menu`
--

CREATE TABLE `so_admin_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '菜单类型;1:有界面可访问菜单,2:无界面可访问菜单,0:只作为菜单',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态;1:显示,0:不显示',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `app` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '应用名',
  `controller` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '控制器名',
  `action` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '操作名称',
  `param` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '额外参数',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单图标',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

--
-- 转存表中的数据 `so_admin_menu`
--

INSERT INTO `so_admin_menu` (`id`, `parent_id`, `type`, `status`, `list_order`, `app`, `controller`, `action`, `param`, `name`, `icon`, `remark`) VALUES
(1, 0, 0, 1, 20, 'admin', 'Plugin', 'default', '', '插件中心', 'cloud', '插件中心'),
(2, 1, 1, 1, 10000, 'admin', 'Hook', 'index', '', '钩子管理', '', '钩子管理'),
(3, 2, 1, 0, 10000, 'admin', 'Hook', 'plugins', '', '钩子插件管理', '', '钩子插件管理'),
(4, 2, 2, 0, 10000, 'admin', 'Hook', 'pluginListOrder', '', '钩子插件排序', '', '钩子插件排序'),
(5, 2, 1, 0, 10000, 'admin', 'Hook', 'sync', '', '同步钩子', '', '同步钩子'),
(6, 0, 0, 1, 0, 'admin', 'Setting', 'default', '', '设置', 'cogs', '系统设置入口'),
(7, 6, 1, 1, 50, 'admin', 'Link', 'index', '', '友情链接', '', '友情链接管理'),
(8, 7, 1, 0, 10000, 'admin', 'Link', 'add', '', '添加友情链接', '', '添加友情链接'),
(9, 7, 2, 0, 10000, 'admin', 'Link', 'addPost', '', '添加友情链接提交保存', '', '添加友情链接提交保存'),
(10, 7, 1, 0, 10000, 'admin', 'Link', 'edit', '', '编辑友情链接', '', '编辑友情链接'),
(11, 7, 2, 0, 10000, 'admin', 'Link', 'editPost', '', '编辑友情链接提交保存', '', '编辑友情链接提交保存'),
(12, 7, 2, 0, 10000, 'admin', 'Link', 'delete', '', '删除友情链接', '', '删除友情链接'),
(13, 7, 2, 0, 10000, 'admin', 'Link', 'listOrder', '', '友情链接排序', '', '友情链接排序'),
(14, 7, 2, 0, 10000, 'admin', 'Link', 'toggle', '', '友情链接显示隐藏', '', '友情链接显示隐藏'),
(15, 6, 1, 1, 10, 'admin', 'Mailer', 'index', '', '邮箱配置', '', '邮箱配置'),
(16, 15, 2, 0, 10000, 'admin', 'Mailer', 'indexPost', '', '邮箱配置提交保存', '', '邮箱配置提交保存'),
(17, 15, 1, 0, 10000, 'admin', 'Mailer', 'template', '', '邮件模板', '', '邮件模板'),
(18, 15, 2, 0, 10000, 'admin', 'Mailer', 'templatePost', '', '邮件模板提交', '', '邮件模板提交'),
(19, 15, 1, 0, 10000, 'admin', 'Mailer', 'test', '', '邮件发送测试', '', '邮件发送测试'),
(20, 6, 1, 0, 10000, 'admin', 'Menu', 'index', '', '后台菜单', '', '后台菜单管理'),
(21, 20, 1, 0, 10000, 'admin', 'Menu', 'lists', '', '所有菜单', '', '后台所有菜单列表'),
(22, 20, 1, 0, 10000, 'admin', 'Menu', 'add', '', '后台菜单添加', '', '后台菜单添加'),
(23, 20, 2, 0, 10000, 'admin', 'Menu', 'addPost', '', '后台菜单添加提交保存', '', '后台菜单添加提交保存'),
(24, 20, 1, 0, 10000, 'admin', 'Menu', 'edit', '', '后台菜单编辑', '', '后台菜单编辑'),
(25, 20, 2, 0, 10000, 'admin', 'Menu', 'editPost', '', '后台菜单编辑提交保存', '', '后台菜单编辑提交保存'),
(26, 20, 2, 0, 10000, 'admin', 'Menu', 'delete', '', '后台菜单删除', '', '后台菜单删除'),
(27, 20, 2, 0, 10000, 'admin', 'Menu', 'listOrder', '', '后台菜单排序', '', '后台菜单排序'),
(28, 20, 1, 0, 10000, 'admin', 'Menu', 'getActions', '', '导入新后台菜单', '', '导入新后台菜单'),
(29, 6, 1, 1, 30, 'admin', 'Nav', 'index', '', '导航管理', '', '导航管理'),
(30, 29, 1, 0, 10000, 'admin', 'Nav', 'add', '', '添加导航', '', '添加导航'),
(31, 29, 2, 0, 10000, 'admin', 'Nav', 'addPost', '', '添加导航提交保存', '', '添加导航提交保存'),
(32, 29, 1, 0, 10000, 'admin', 'Nav', 'edit', '', '编辑导航', '', '编辑导航'),
(33, 29, 2, 0, 10000, 'admin', 'Nav', 'editPost', '', '编辑导航提交保存', '', '编辑导航提交保存'),
(34, 29, 2, 0, 10000, 'admin', 'Nav', 'delete', '', '删除导航', '', '删除导航'),
(35, 29, 1, 0, 10000, 'admin', 'NavMenu', 'index', '', '导航菜单', '', '导航菜单'),
(36, 35, 1, 0, 10000, 'admin', 'NavMenu', 'add', '', '添加导航菜单', '', '添加导航菜单'),
(37, 35, 2, 0, 10000, 'admin', 'NavMenu', 'addPost', '', '添加导航菜单提交保存', '', '添加导航菜单提交保存'),
(38, 35, 1, 0, 10000, 'admin', 'NavMenu', 'edit', '', '编辑导航菜单', '', '编辑导航菜单'),
(39, 35, 2, 0, 10000, 'admin', 'NavMenu', 'editPost', '', '编辑导航菜单提交保存', '', '编辑导航菜单提交保存'),
(40, 35, 2, 0, 10000, 'admin', 'NavMenu', 'delete', '', '删除导航菜单', '', '删除导航菜单'),
(41, 35, 2, 0, 10000, 'admin', 'NavMenu', 'listOrder', '', '导航菜单排序', '', '导航菜单排序'),
(42, 1, 1, 1, 10000, 'admin', 'Plugin', 'index', '', '插件列表', '', '插件列表'),
(43, 42, 2, 0, 10000, 'admin', 'Plugin', 'toggle', '', '插件启用禁用', '', '插件启用禁用'),
(44, 42, 1, 0, 10000, 'admin', 'Plugin', 'setting', '', '插件设置', '', '插件设置'),
(45, 42, 2, 0, 10000, 'admin', 'Plugin', 'settingPost', '', '插件设置提交', '', '插件设置提交'),
(46, 42, 2, 0, 10000, 'admin', 'Plugin', 'install', '', '插件安装', '', '插件安装'),
(47, 42, 2, 0, 10000, 'admin', 'Plugin', 'update', '', '插件更新', '', '插件更新'),
(48, 42, 2, 0, 10000, 'admin', 'Plugin', 'uninstall', '', '卸载插件', '', '卸载插件'),
(49, 110, 0, 1, 10000, 'admin', 'User', 'default', '', '管理组', '', '管理组'),
(50, 49, 1, 1, 10000, 'admin', 'Rbac', 'index', '', '角色管理', '', '角色管理'),
(51, 50, 1, 0, 10000, 'admin', 'Rbac', 'roleAdd', '', '添加角色', '', '添加角色'),
(52, 50, 2, 0, 10000, 'admin', 'Rbac', 'roleAddPost', '', '添加角色提交', '', '添加角色提交'),
(53, 50, 1, 0, 10000, 'admin', 'Rbac', 'roleEdit', '', '编辑角色', '', '编辑角色'),
(54, 50, 2, 0, 10000, 'admin', 'Rbac', 'roleEditPost', '', '编辑角色提交', '', '编辑角色提交'),
(55, 50, 2, 0, 10000, 'admin', 'Rbac', 'roleDelete', '', '删除角色', '', '删除角色'),
(56, 50, 1, 0, 10000, 'admin', 'Rbac', 'authorize', '', '设置角色权限', '', '设置角色权限'),
(57, 50, 2, 0, 10000, 'admin', 'Rbac', 'authorizePost', '', '角色授权提交', '', '角色授权提交'),
(58, 0, 1, 0, 10000, 'admin', 'RecycleBin', 'index', '', '回收站', '', '回收站'),
(59, 58, 2, 0, 10000, 'admin', 'RecycleBin', 'restore', '', '回收站还原', '', '回收站还原'),
(60, 58, 2, 0, 10000, 'admin', 'RecycleBin', 'delete', '', '回收站彻底删除', '', '回收站彻底删除'),
(61, 6, 1, 1, 10000, 'admin', 'Route', 'index', '', 'URL美化', '', 'URL规则管理'),
(62, 61, 1, 0, 10000, 'admin', 'Route', 'add', '', '添加路由规则', '', '添加路由规则'),
(63, 61, 2, 0, 10000, 'admin', 'Route', 'addPost', '', '添加路由规则提交', '', '添加路由规则提交'),
(64, 61, 1, 0, 10000, 'admin', 'Route', 'edit', '', '路由规则编辑', '', '路由规则编辑'),
(65, 61, 2, 0, 10000, 'admin', 'Route', 'editPost', '', '路由规则编辑提交', '', '路由规则编辑提交'),
(66, 61, 2, 0, 10000, 'admin', 'Route', 'delete', '', '路由规则删除', '', '路由规则删除'),
(67, 61, 2, 0, 10000, 'admin', 'Route', 'ban', '', '路由规则禁用', '', '路由规则禁用'),
(68, 61, 2, 0, 10000, 'admin', 'Route', 'open', '', '路由规则启用', '', '路由规则启用'),
(69, 61, 2, 0, 10000, 'admin', 'Route', 'listOrder', '', '路由规则排序', '', '路由规则排序'),
(70, 61, 1, 0, 10000, 'admin', 'Route', 'select', '', '选择URL', '', '选择URL'),
(71, 6, 1, 1, 0, 'admin', 'Setting', 'site', '', '网站信息', '', '网站信息'),
(72, 71, 2, 0, 10000, 'admin', 'Setting', 'sitePost', '', '网站信息设置提交', '', '网站信息设置提交'),
(73, 6, 1, 0, 10000, 'admin', 'Setting', 'password', '', '密码修改', '', '密码修改'),
(74, 73, 2, 0, 10000, 'admin', 'Setting', 'passwordPost', '', '密码修改提交', '', '密码修改提交'),
(75, 6, 1, 1, 10000, 'admin', 'Setting', 'upload', '', '上传设置', '', '上传设置'),
(76, 75, 2, 0, 10000, 'admin', 'Setting', 'uploadPost', '', '上传设置提交', '', '上传设置提交'),
(77, 6, 1, 0, 10000, 'admin', 'Setting', 'clearCache', '', '清除缓存', '', '清除缓存'),
(78, 6, 1, 1, 40, 'admin', 'Slide', 'index', '', '幻灯片管理', '', '幻灯片管理'),
(79, 78, 1, 0, 10000, 'admin', 'Slide', 'add', '', '添加幻灯片', '', '添加幻灯片'),
(80, 78, 2, 0, 10000, 'admin', 'Slide', 'addPost', '', '添加幻灯片提交', '', '添加幻灯片提交'),
(81, 78, 1, 0, 10000, 'admin', 'Slide', 'edit', '', '编辑幻灯片', '', '编辑幻灯片'),
(82, 78, 2, 0, 10000, 'admin', 'Slide', 'editPost', '', '编辑幻灯片提交', '', '编辑幻灯片提交'),
(83, 78, 2, 0, 10000, 'admin', 'Slide', 'delete', '', '删除幻灯片', '', '删除幻灯片'),
(84, 78, 1, 0, 10000, 'admin', 'SlideItem', 'index', '', '幻灯片页面列表', '', '幻灯片页面列表'),
(85, 84, 1, 0, 10000, 'admin', 'SlideItem', 'add', '', '幻灯片页面添加', '', '幻灯片页面添加'),
(86, 84, 2, 0, 10000, 'admin', 'SlideItem', 'addPost', '', '幻灯片页面添加提交', '', '幻灯片页面添加提交'),
(87, 84, 1, 0, 10000, 'admin', 'SlideItem', 'edit', '', '幻灯片页面编辑', '', '幻灯片页面编辑'),
(88, 84, 2, 0, 10000, 'admin', 'SlideItem', 'editPost', '', '幻灯片页面编辑提交', '', '幻灯片页面编辑提交'),
(89, 84, 2, 0, 10000, 'admin', 'SlideItem', 'delete', '', '幻灯片页面删除', '', '幻灯片页面删除'),
(90, 84, 2, 0, 10000, 'admin', 'SlideItem', 'ban', '', '幻灯片页面隐藏', '', '幻灯片页面隐藏'),
(91, 84, 2, 0, 10000, 'admin', 'SlideItem', 'cancelBan', '', '幻灯片页面显示', '', '幻灯片页面显示'),
(92, 84, 2, 0, 10000, 'admin', 'SlideItem', 'listOrder', '', '幻灯片页面排序', '', '幻灯片页面排序'),
(93, 6, 1, 1, 10000, 'admin', 'Storage', 'index', '', '文件存储', '', '文件存储'),
(94, 93, 2, 0, 10000, 'admin', 'Storage', 'settingPost', '', '文件存储设置提交', '', '文件存储设置提交'),
(95, 6, 1, 1, 20, 'admin', 'Theme', 'index', '', '模板管理', '', '模板管理'),
(96, 95, 1, 0, 10000, 'admin', 'Theme', 'install', '', '安装模板', '', '安装模板'),
(97, 95, 2, 0, 10000, 'admin', 'Theme', 'uninstall', '', '卸载模板', '', '卸载模板'),
(98, 95, 2, 0, 10000, 'admin', 'Theme', 'installTheme', '', '模板安装', '', '模板安装'),
(99, 95, 2, 0, 10000, 'admin', 'Theme', 'update', '', '模板更新', '', '模板更新'),
(100, 95, 2, 0, 10000, 'admin', 'Theme', 'active', '', '启用模板', '', '启用模板'),
(101, 95, 1, 0, 10000, 'admin', 'Theme', 'files', '', '模板文件列表', '', '启用模板'),
(102, 95, 1, 0, 10000, 'admin', 'Theme', 'fileSetting', '', '模板文件设置', '', '模板文件设置'),
(103, 95, 1, 0, 10000, 'admin', 'Theme', 'fileArrayData', '', '模板文件数组数据列表', '', '模板文件数组数据列表'),
(104, 95, 2, 0, 10000, 'admin', 'Theme', 'fileArrayDataEdit', '', '模板文件数组数据添加编辑', '', '模板文件数组数据添加编辑'),
(105, 95, 2, 0, 10000, 'admin', 'Theme', 'fileArrayDataEditPost', '', '模板文件数组数据添加编辑提交保存', '', '模板文件数组数据添加编辑提交保存'),
(106, 95, 2, 0, 10000, 'admin', 'Theme', 'fileArrayDataDelete', '', '模板文件数组数据删除', '', '模板文件数组数据删除'),
(107, 95, 2, 0, 10000, 'admin', 'Theme', 'settingPost', '', '模板文件编辑提交保存', '', '模板文件编辑提交保存'),
(108, 95, 1, 0, 10000, 'admin', 'Theme', 'dataSource', '', '模板文件设置数据源', '', '模板文件设置数据源'),
(109, 95, 1, 0, 10000, 'admin', 'Theme', 'design', '', '模板设计', '', '模板设计'),
(110, 0, 0, 1, 10, 'user', 'AdminIndex', 'default', '', '角色管理', 'group', '用户管理'),
(111, 49, 1, 1, 10000, 'admin', 'User', 'index', '', '管理员', '', '管理员管理'),
(112, 111, 1, 0, 10000, 'admin', 'User', 'add', '', '管理员添加', '', '管理员添加'),
(113, 111, 2, 0, 10000, 'admin', 'User', 'addPost', '', '管理员添加提交', '', '管理员添加提交'),
(114, 111, 1, 0, 10000, 'admin', 'User', 'edit', '', '管理员编辑', '', '管理员编辑'),
(115, 111, 2, 0, 10000, 'admin', 'User', 'editPost', '', '管理员编辑提交', '', '管理员编辑提交'),
(116, 111, 1, 0, 10000, 'admin', 'User', 'userInfo', '', '个人信息', '', '管理员个人信息修改'),
(117, 111, 2, 0, 10000, 'admin', 'User', 'userInfoPost', '', '管理员个人信息修改提交', '', '管理员个人信息修改提交'),
(118, 111, 2, 0, 10000, 'admin', 'User', 'delete', '', '管理员删除', '', '管理员删除'),
(119, 111, 2, 0, 10000, 'admin', 'User', 'ban', '', '停用管理员', '', '停用管理员'),
(120, 111, 2, 0, 10000, 'admin', 'User', 'cancelBan', '', '启用管理员', '', '启用管理员'),
(121, 0, 0, 1, 30, 'portal', 'AdminIndex', 'default', '', '门户管理', 'th', '门户管理'),
(122, 121, 1, 1, 10000, 'portal', 'AdminArticle', 'index', '', '文章管理', '', '文章列表'),
(123, 122, 1, 0, 10000, 'portal', 'AdminArticle', 'add', '', '添加文章', '', '添加文章'),
(124, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'addPost', '', '添加文章提交', '', '添加文章提交'),
(125, 122, 1, 0, 10000, 'portal', 'AdminArticle', 'edit', '', '编辑文章', '', '编辑文章'),
(126, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'editPost', '', '编辑文章提交', '', '编辑文章提交'),
(127, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'delete', '', '文章删除', '', '文章删除'),
(128, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'publish', '', '文章发布', '', '文章发布'),
(129, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'top', '', '文章置顶', '', '文章置顶'),
(130, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'recommend', '', '文章推荐', '', '文章推荐'),
(131, 122, 2, 0, 10000, 'portal', 'AdminArticle', 'listOrder', '', '文章排序', '', '文章排序'),
(132, 121, 1, 1, 10000, 'portal', 'AdminCategory', 'index', '', '分类管理', '', '文章分类列表'),
(133, 132, 1, 0, 10000, 'portal', 'AdminCategory', 'add', '', '添加文章分类', '', '添加文章分类'),
(134, 132, 2, 0, 10000, 'portal', 'AdminCategory', 'addPost', '', '添加文章分类提交', '', '添加文章分类提交'),
(135, 132, 1, 0, 10000, 'portal', 'AdminCategory', 'edit', '', '编辑文章分类', '', '编辑文章分类'),
(136, 132, 2, 0, 10000, 'portal', 'AdminCategory', 'editPost', '', '编辑文章分类提交', '', '编辑文章分类提交'),
(137, 132, 1, 0, 10000, 'portal', 'AdminCategory', 'select', '', '文章分类选择对话框', '', '文章分类选择对话框'),
(138, 132, 2, 0, 10000, 'portal', 'AdminCategory', 'listOrder', '', '文章分类排序', '', '文章分类排序'),
(139, 132, 2, 0, 10000, 'portal', 'AdminCategory', 'delete', '', '删除文章分类', '', '删除文章分类'),
(140, 121, 1, 1, 10000, 'portal', 'AdminPage', 'index', '', '页面管理', '', '页面管理'),
(141, 140, 1, 0, 10000, 'portal', 'AdminPage', 'add', '', '添加页面', '', '添加页面'),
(142, 140, 2, 0, 10000, 'portal', 'AdminPage', 'addPost', '', '添加页面提交', '', '添加页面提交'),
(143, 140, 1, 0, 10000, 'portal', 'AdminPage', 'edit', '', '编辑页面', '', '编辑页面'),
(144, 140, 2, 0, 10000, 'portal', 'AdminPage', 'editPost', '', '编辑页面提交', '', '编辑页面提交'),
(145, 140, 2, 0, 10000, 'portal', 'AdminPage', 'delete', '', '删除页面', '', '删除页面'),
(146, 121, 1, 1, 10000, 'portal', 'AdminTag', 'index', '', '文章标签', '', '文章标签'),
(147, 146, 1, 0, 10000, 'portal', 'AdminTag', 'add', '', '添加文章标签', '', '添加文章标签'),
(148, 146, 2, 0, 10000, 'portal', 'AdminTag', 'addPost', '', '添加文章标签提交', '', '添加文章标签提交'),
(149, 146, 2, 0, 10000, 'portal', 'AdminTag', 'upStatus', '', '更新标签状态', '', '更新标签状态'),
(150, 146, 2, 0, 10000, 'portal', 'AdminTag', 'delete', '', '删除文章标签', '', '删除文章标签'),
(151, 0, 1, 0, 10000, 'user', 'AdminAsset', 'index', '', '资源管理', 'file', '资源管理列表'),
(152, 151, 2, 0, 10000, 'user', 'AdminAsset', 'delete', '', '删除文件', '', '删除文件'),
(153, 110, 0, 0, 10000, 'user', 'AdminIndex', 'default1', '', '用户组', '', '用户组'),
(154, 153, 1, 1, 10000, 'user', 'AdminIndex', 'index', '', '本站用户', '', '本站用户'),
(155, 154, 2, 0, 10000, 'user', 'AdminIndex', 'ban', '', '本站用户拉黑', '', '本站用户拉黑'),
(156, 154, 2, 0, 10000, 'user', 'AdminIndex', 'cancelBan', '', '本站用户启用', '', '本站用户启用'),
(157, 153, 1, 1, 10000, 'user', 'AdminOauth', 'index', '', '第三方用户', '', '第三方用户'),
(158, 157, 2, 0, 10000, 'user', 'AdminOauth', 'delete', '', '删除第三方用户绑定', '', '删除第三方用户绑定'),
(159, 6, 1, 1, 10000, 'user', 'AdminUserAction', 'index', '', '用户操作管理', '', '用户操作管理'),
(160, 159, 1, 0, 10000, 'user', 'AdminUserAction', 'edit', '', '编辑用户操作', '', '编辑用户操作'),
(161, 159, 2, 0, 10000, 'user', 'AdminUserAction', 'editPost', '', '编辑用户操作提交', '', '编辑用户操作提交'),
(162, 159, 1, 0, 10000, 'user', 'AdminUserAction', 'sync', '', '同步用户操作', '', '同步用户操作'),
(163, 1, 1, 1, 10000, 'plugin/Wxapp', 'AdminIndex', 'index', '', '小程序管理', '', '小程序管理'),
(164, 163, 1, 0, 10000, 'plugin/Wxapp', 'AdminWxapp', 'add', '', '添加小程序', '', '添加小程序'),
(165, 163, 2, 0, 10000, 'plugin/Wxapp', 'AdminWxapp', 'addPost', '', '添加小程序提交保存', '', '添加小程序提交保存'),
(166, 163, 1, 0, 10000, 'plugin/Wxapp', 'AdminWxapp', 'edit', '', '编辑小程序', '', '编辑小程序'),
(167, 163, 2, 0, 10000, 'plugin/Wxapp', 'AdminWxapp', 'editPost', '', '编辑小程序提交保存', '', '编辑小程序'),
(168, 163, 2, 0, 10000, 'plugin/Wxapp', 'AdminWxapp', 'delete', '', '删除小程序', '', '删除小程序'),
(169, 0, 0, 1, 10000, 'user', 'AdminIndex', 'index', '', '员工管理', 'user-circle', '员工管理\r\n'),
(170, 169, 1, 1, 10000, 'user', 'AdminIndex', 'index', '', '员工管理', '', ''),
(171, 0, 0, 1, 10000, 'frame', 'AdminIndex', 'default', '', '组织架构管理', 'sitemap ', ''),
(172, 171, 1, 1, 10000, 'frame', 'AdminIndex', 'index', '', '组织架构管理', '', ''),
(177, 169, 1, 1, 10000, 'vague', 'AdminIndex', 'index', '', '模糊岗位管理', '', ''),
(178, 169, 1, 1, 10000, 'identity', 'AdminIndex', 'index', '', '员工身份管理', '', ''),
(179, 169, 1, 1, 10000, 'role', 'AdminIndex', 'index', '', '员工角色管理', '', ''),
(180, 0, 0, 1, 10000, 'seal', 'AdminIndex', 'index', '', '行政公章管理', 'key', ''),
(181, 180, 1, 1, 10000, 'seal', 'AdminIndex', 'index', '', '行政公章管理', '', ''),
(182, 0, 0, 1, 10000, 'protocol', 'AdminIndex', 'index', '', '协议管理', 'book', ''),
(183, 182, 1, 1, 10000, 'protocol', 'AdminIndex', 'index', '', '协议管理', '', ''),
(184, 182, 1, 1, 10000, 'protocol', 'AdminCategory', 'index', '', '协议模板管理', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `so_asset`
--

CREATE TABLE `so_asset` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `file_size` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文件大小,单位B',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上传时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:可用,0:不可用',
  `download_times` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '下载次数',
  `file_key` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件惟一码',
  `filename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `file_path` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件路径,相对于upload目录,可以为url',
  `file_md5` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '文件md5值',
  `file_sha1` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `suffix` varchar(10) NOT NULL DEFAULT '' COMMENT '文件后缀名,不包括点',
  `more` text COMMENT '其它详细信息,JSON格式'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='资源表';

--
-- 转存表中的数据 `so_asset`
--

INSERT INTO `so_asset` (`id`, `user_id`, `file_size`, `create_time`, `status`, `download_times`, `file_key`, `filename`, `file_path`, `file_md5`, `file_sha1`, `suffix`, `more`) VALUES
(1, 1, 42062, 1542726935, 1, 0, 'f358dc5343698f0bdc5c218c027a0c036a42f27f60cef91c1e7747df2b925aa2', '微信图片_20181120013222.png', 'seal/20181120/e42b25bf3da4c4d4244adebdb7c53fee.png', 'f358dc5343698f0bdc5c218c027a0c03', '087d07420d19ea769d69016cffe57ea3c832c115', 'png', NULL),
(2, 1, 113152, 1543149879, 1, 0, 'd4b9b01f567b00f79471c151fe99f77b6deacf3263fe3287739094b6723ac466', '737fb6782eeb3f04815d5f6946be2579.doc', 'protocol/20181125/7572c233aa90fab605504ec89bab1f99.doc', 'd4b9b01f567b00f79471c151fe99f77b', '4ac2c040de6cfa5bf84690d14269fa060026c11b', 'doc', NULL),
(3, 1, 111616, 1543150010, 1, 0, '1a9eb08c90cc02877cc64e5d13f9762995e1720583994345c5ea6cc0cd9d88fc', '0197480755757d084f48ed2589b2c8f4 (2).doc', 'protocol/20181125/ca23f8da1118116d6d84783fee9f527a.doc', '1a9eb08c90cc02877cc64e5d13f97629', 'dbec470e29fef1eb919ca1bf5e46d0afee89540a', 'doc', NULL),
(4, 1, 5236, 1543241117, 1, 0, '47551fdab8d975d7a9fbe63d30d51e956b5c0b4728478045e4788e943deb60b8', 'safety certificate.png', 'user/20181126/ddea8b7a34e201e2a4207cf505e78c50.png', '47551fdab8d975d7a9fbe63d30d51e95', '3c37090abe9aa84981ab562fb80d68793a104dde', 'png', NULL),
(5, 1, 5545, 1543241324, 1, 0, 'd3b4f02b2db98ba5a671bdc47e8da58098d6700377565e8d5e02663c8a619546', 'user.png', 'user/20181126/87e7838f91be33169ba9a4d97fcea259.png', 'd3b4f02b2db98ba5a671bdc47e8da580', '4cf979d907d957ee85e78dd5c8946f0622ad2e9f', 'png', NULL),
(6, 1, 112640, 1543509197, 1, 0, 'b1c10f189e3262a340e23990ad4779606bbc72725e5dc5e3dea103aae07c3e8f', '国网浙江省电力有限公司保密工作责任书（通用部门）.doc', 'protocol/20181130/9f5547026c59bd24a06c192af74dd462.doc', 'b1c10f189e3262a340e23990ad477960', 'daeae87c13d1d2d5f2038b3b30db69ea4fed7cdc', 'doc', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_auth_access`
--

CREATE TABLE `so_auth_access` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL COMMENT '角色',
  `rule_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类,请加应用前缀,如admin_'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- --------------------------------------------------------

--
-- 表的结构 `so_auth_rule`
--

CREATE TABLE `so_auth_rule` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '规则id,自增主键',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `app` varchar(40) NOT NULL DEFAULT '' COMMENT '规则所属app',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(100) NOT NULL DEFAULT '' COMMENT '额外url参数',
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则描述',
  `condition` varchar(200) NOT NULL DEFAULT '' COMMENT '规则附加条件'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限规则表';

--
-- 转存表中的数据 `so_auth_rule`
--

INSERT INTO `so_auth_rule` (`id`, `status`, `app`, `type`, `name`, `param`, `title`, `condition`) VALUES
(1, 1, 'admin', 'admin_url', 'admin/Hook/index', '', '钩子管理', ''),
(2, 1, 'admin', 'admin_url', 'admin/Hook/plugins', '', '钩子插件管理', ''),
(3, 1, 'admin', 'admin_url', 'admin/Hook/pluginListOrder', '', '钩子插件排序', ''),
(4, 1, 'admin', 'admin_url', 'admin/Hook/sync', '', '同步钩子', ''),
(5, 1, 'admin', 'admin_url', 'admin/Link/index', '', '友情链接', ''),
(6, 1, 'admin', 'admin_url', 'admin/Link/add', '', '添加友情链接', ''),
(7, 1, 'admin', 'admin_url', 'admin/Link/addPost', '', '添加友情链接提交保存', ''),
(8, 1, 'admin', 'admin_url', 'admin/Link/edit', '', '编辑友情链接', ''),
(9, 1, 'admin', 'admin_url', 'admin/Link/editPost', '', '编辑友情链接提交保存', ''),
(10, 1, 'admin', 'admin_url', 'admin/Link/delete', '', '删除友情链接', ''),
(11, 1, 'admin', 'admin_url', 'admin/Link/listOrder', '', '友情链接排序', ''),
(12, 1, 'admin', 'admin_url', 'admin/Link/toggle', '', '友情链接显示隐藏', ''),
(13, 1, 'admin', 'admin_url', 'admin/Mailer/index', '', '邮箱配置', ''),
(14, 1, 'admin', 'admin_url', 'admin/Mailer/indexPost', '', '邮箱配置提交保存', ''),
(15, 1, 'admin', 'admin_url', 'admin/Mailer/template', '', '邮件模板', ''),
(16, 1, 'admin', 'admin_url', 'admin/Mailer/templatePost', '', '邮件模板提交', ''),
(17, 1, 'admin', 'admin_url', 'admin/Mailer/test', '', '邮件发送测试', ''),
(18, 1, 'admin', 'admin_url', 'admin/Menu/index', '', '后台菜单', ''),
(19, 1, 'admin', 'admin_url', 'admin/Menu/lists', '', '所有菜单', ''),
(20, 1, 'admin', 'admin_url', 'admin/Menu/add', '', '后台菜单添加', ''),
(21, 1, 'admin', 'admin_url', 'admin/Menu/addPost', '', '后台菜单添加提交保存', ''),
(22, 1, 'admin', 'admin_url', 'admin/Menu/edit', '', '后台菜单编辑', ''),
(23, 1, 'admin', 'admin_url', 'admin/Menu/editPost', '', '后台菜单编辑提交保存', ''),
(24, 1, 'admin', 'admin_url', 'admin/Menu/delete', '', '后台菜单删除', ''),
(25, 1, 'admin', 'admin_url', 'admin/Menu/listOrder', '', '后台菜单排序', ''),
(26, 1, 'admin', 'admin_url', 'admin/Menu/getActions', '', '导入新后台菜单', ''),
(27, 1, 'admin', 'admin_url', 'admin/Nav/index', '', '导航管理', ''),
(28, 1, 'admin', 'admin_url', 'admin/Nav/add', '', '添加导航', ''),
(29, 1, 'admin', 'admin_url', 'admin/Nav/addPost', '', '添加导航提交保存', ''),
(30, 1, 'admin', 'admin_url', 'admin/Nav/edit', '', '编辑导航', ''),
(31, 1, 'admin', 'admin_url', 'admin/Nav/editPost', '', '编辑导航提交保存', ''),
(32, 1, 'admin', 'admin_url', 'admin/Nav/delete', '', '删除导航', ''),
(33, 1, 'admin', 'admin_url', 'admin/NavMenu/index', '', '导航菜单', ''),
(34, 1, 'admin', 'admin_url', 'admin/NavMenu/add', '', '添加导航菜单', ''),
(35, 1, 'admin', 'admin_url', 'admin/NavMenu/addPost', '', '添加导航菜单提交保存', ''),
(36, 1, 'admin', 'admin_url', 'admin/NavMenu/edit', '', '编辑导航菜单', ''),
(37, 1, 'admin', 'admin_url', 'admin/NavMenu/editPost', '', '编辑导航菜单提交保存', ''),
(38, 1, 'admin', 'admin_url', 'admin/NavMenu/delete', '', '删除导航菜单', ''),
(39, 1, 'admin', 'admin_url', 'admin/NavMenu/listOrder', '', '导航菜单排序', ''),
(40, 1, 'admin', 'admin_url', 'admin/Plugin/default', '', '插件中心', ''),
(41, 1, 'admin', 'admin_url', 'admin/Plugin/index', '', '插件列表', ''),
(42, 1, 'admin', 'admin_url', 'admin/Plugin/toggle', '', '插件启用禁用', ''),
(43, 1, 'admin', 'admin_url', 'admin/Plugin/setting', '', '插件设置', ''),
(44, 1, 'admin', 'admin_url', 'admin/Plugin/settingPost', '', '插件设置提交', ''),
(45, 1, 'admin', 'admin_url', 'admin/Plugin/install', '', '插件安装', ''),
(46, 1, 'admin', 'admin_url', 'admin/Plugin/update', '', '插件更新', ''),
(47, 1, 'admin', 'admin_url', 'admin/Plugin/uninstall', '', '卸载插件', ''),
(48, 1, 'admin', 'admin_url', 'admin/Rbac/index', '', '角色管理', ''),
(49, 1, 'admin', 'admin_url', 'admin/Rbac/roleAdd', '', '添加角色', ''),
(50, 1, 'admin', 'admin_url', 'admin/Rbac/roleAddPost', '', '添加角色提交', ''),
(51, 1, 'admin', 'admin_url', 'admin/Rbac/roleEdit', '', '编辑角色', ''),
(52, 1, 'admin', 'admin_url', 'admin/Rbac/roleEditPost', '', '编辑角色提交', ''),
(53, 1, 'admin', 'admin_url', 'admin/Rbac/roleDelete', '', '删除角色', ''),
(54, 1, 'admin', 'admin_url', 'admin/Rbac/authorize', '', '设置角色权限', ''),
(55, 1, 'admin', 'admin_url', 'admin/Rbac/authorizePost', '', '角色授权提交', ''),
(56, 1, 'admin', 'admin_url', 'admin/RecycleBin/index', '', '回收站', ''),
(57, 1, 'admin', 'admin_url', 'admin/RecycleBin/restore', '', '回收站还原', ''),
(58, 1, 'admin', 'admin_url', 'admin/RecycleBin/delete', '', '回收站彻底删除', ''),
(59, 1, 'admin', 'admin_url', 'admin/Route/index', '', 'URL美化', ''),
(60, 1, 'admin', 'admin_url', 'admin/Route/add', '', '添加路由规则', ''),
(61, 1, 'admin', 'admin_url', 'admin/Route/addPost', '', '添加路由规则提交', ''),
(62, 1, 'admin', 'admin_url', 'admin/Route/edit', '', '路由规则编辑', ''),
(63, 1, 'admin', 'admin_url', 'admin/Route/editPost', '', '路由规则编辑提交', ''),
(64, 1, 'admin', 'admin_url', 'admin/Route/delete', '', '路由规则删除', ''),
(65, 1, 'admin', 'admin_url', 'admin/Route/ban', '', '路由规则禁用', ''),
(66, 1, 'admin', 'admin_url', 'admin/Route/open', '', '路由规则启用', ''),
(67, 1, 'admin', 'admin_url', 'admin/Route/listOrder', '', '路由规则排序', ''),
(68, 1, 'admin', 'admin_url', 'admin/Route/select', '', '选择URL', ''),
(69, 1, 'admin', 'admin_url', 'admin/Setting/default', '', '设置', ''),
(70, 1, 'admin', 'admin_url', 'admin/Setting/site', '', '网站信息', ''),
(71, 1, 'admin', 'admin_url', 'admin/Setting/sitePost', '', '网站信息设置提交', ''),
(72, 1, 'admin', 'admin_url', 'admin/Setting/password', '', '密码修改', ''),
(73, 1, 'admin', 'admin_url', 'admin/Setting/passwordPost', '', '密码修改提交', ''),
(74, 1, 'admin', 'admin_url', 'admin/Setting/upload', '', '上传设置', ''),
(75, 1, 'admin', 'admin_url', 'admin/Setting/uploadPost', '', '上传设置提交', ''),
(76, 1, 'admin', 'admin_url', 'admin/Setting/clearCache', '', '清除缓存', ''),
(77, 1, 'admin', 'admin_url', 'admin/Slide/index', '', '幻灯片管理', ''),
(78, 1, 'admin', 'admin_url', 'admin/Slide/add', '', '添加幻灯片', ''),
(79, 1, 'admin', 'admin_url', 'admin/Slide/addPost', '', '添加幻灯片提交', ''),
(80, 1, 'admin', 'admin_url', 'admin/Slide/edit', '', '编辑幻灯片', ''),
(81, 1, 'admin', 'admin_url', 'admin/Slide/editPost', '', '编辑幻灯片提交', ''),
(82, 1, 'admin', 'admin_url', 'admin/Slide/delete', '', '删除幻灯片', ''),
(83, 1, 'admin', 'admin_url', 'admin/SlideItem/index', '', '幻灯片页面列表', ''),
(84, 1, 'admin', 'admin_url', 'admin/SlideItem/add', '', '幻灯片页面添加', ''),
(85, 1, 'admin', 'admin_url', 'admin/SlideItem/addPost', '', '幻灯片页面添加提交', ''),
(86, 1, 'admin', 'admin_url', 'admin/SlideItem/edit', '', '幻灯片页面编辑', ''),
(87, 1, 'admin', 'admin_url', 'admin/SlideItem/editPost', '', '幻灯片页面编辑提交', ''),
(88, 1, 'admin', 'admin_url', 'admin/SlideItem/delete', '', '幻灯片页面删除', ''),
(89, 1, 'admin', 'admin_url', 'admin/SlideItem/ban', '', '幻灯片页面隐藏', ''),
(90, 1, 'admin', 'admin_url', 'admin/SlideItem/cancelBan', '', '幻灯片页面显示', ''),
(91, 1, 'admin', 'admin_url', 'admin/SlideItem/listOrder', '', '幻灯片页面排序', ''),
(92, 1, 'admin', 'admin_url', 'admin/Storage/index', '', '文件存储', ''),
(93, 1, 'admin', 'admin_url', 'admin/Storage/settingPost', '', '文件存储设置提交', ''),
(94, 1, 'admin', 'admin_url', 'admin/Theme/index', '', '模板管理', ''),
(95, 1, 'admin', 'admin_url', 'admin/Theme/install', '', '安装模板', ''),
(96, 1, 'admin', 'admin_url', 'admin/Theme/uninstall', '', '卸载模板', ''),
(97, 1, 'admin', 'admin_url', 'admin/Theme/installTheme', '', '模板安装', ''),
(98, 1, 'admin', 'admin_url', 'admin/Theme/update', '', '模板更新', ''),
(99, 1, 'admin', 'admin_url', 'admin/Theme/active', '', '启用模板', ''),
(100, 1, 'admin', 'admin_url', 'admin/Theme/files', '', '模板文件列表', ''),
(101, 1, 'admin', 'admin_url', 'admin/Theme/fileSetting', '', '模板文件设置', ''),
(102, 1, 'admin', 'admin_url', 'admin/Theme/fileArrayData', '', '模板文件数组数据列表', ''),
(103, 1, 'admin', 'admin_url', 'admin/Theme/fileArrayDataEdit', '', '模板文件数组数据添加编辑', ''),
(104, 1, 'admin', 'admin_url', 'admin/Theme/fileArrayDataEditPost', '', '模板文件数组数据添加编辑提交保存', ''),
(105, 1, 'admin', 'admin_url', 'admin/Theme/fileArrayDataDelete', '', '模板文件数组数据删除', ''),
(106, 1, 'admin', 'admin_url', 'admin/Theme/settingPost', '', '模板文件编辑提交保存', ''),
(107, 1, 'admin', 'admin_url', 'admin/Theme/dataSource', '', '模板文件设置数据源', ''),
(108, 1, 'admin', 'admin_url', 'admin/Theme/design', '', '模板设计', ''),
(109, 1, 'admin', 'admin_url', 'admin/User/default', '', '管理组', ''),
(110, 1, 'admin', 'admin_url', 'admin/User/index', '', '管理员', ''),
(111, 1, 'admin', 'admin_url', 'admin/User/add', '', '管理员添加', ''),
(112, 1, 'admin', 'admin_url', 'admin/User/addPost', '', '管理员添加提交', ''),
(113, 1, 'admin', 'admin_url', 'admin/User/edit', '', '管理员编辑', ''),
(114, 1, 'admin', 'admin_url', 'admin/User/editPost', '', '管理员编辑提交', ''),
(115, 1, 'admin', 'admin_url', 'admin/User/userInfo', '', '个人信息', ''),
(116, 1, 'admin', 'admin_url', 'admin/User/userInfoPost', '', '管理员个人信息修改提交', ''),
(117, 1, 'admin', 'admin_url', 'admin/User/delete', '', '管理员删除', ''),
(118, 1, 'admin', 'admin_url', 'admin/User/ban', '', '停用管理员', ''),
(119, 1, 'admin', 'admin_url', 'admin/User/cancelBan', '', '启用管理员', ''),
(120, 1, 'portal', 'admin_url', 'portal/AdminArticle/index', '', '文章管理', ''),
(121, 1, 'portal', 'admin_url', 'portal/AdminArticle/add', '', '添加文章', ''),
(122, 1, 'portal', 'admin_url', 'portal/AdminArticle/addPost', '', '添加文章提交', ''),
(123, 1, 'portal', 'admin_url', 'portal/AdminArticle/edit', '', '编辑文章', ''),
(124, 1, 'portal', 'admin_url', 'portal/AdminArticle/editPost', '', '编辑文章提交', ''),
(125, 1, 'portal', 'admin_url', 'portal/AdminArticle/delete', '', '文章删除', ''),
(126, 1, 'portal', 'admin_url', 'portal/AdminArticle/publish', '', '文章发布', ''),
(127, 1, 'portal', 'admin_url', 'portal/AdminArticle/top', '', '文章置顶', ''),
(128, 1, 'portal', 'admin_url', 'portal/AdminArticle/recommend', '', '文章推荐', ''),
(129, 1, 'portal', 'admin_url', 'portal/AdminArticle/listOrder', '', '文章排序', ''),
(130, 1, 'portal', 'admin_url', 'portal/AdminCategory/index', '', '分类管理', ''),
(131, 1, 'portal', 'admin_url', 'portal/AdminCategory/add', '', '添加文章分类', ''),
(132, 1, 'portal', 'admin_url', 'portal/AdminCategory/addPost', '', '添加文章分类提交', ''),
(133, 1, 'portal', 'admin_url', 'portal/AdminCategory/edit', '', '编辑文章分类', ''),
(134, 1, 'portal', 'admin_url', 'portal/AdminCategory/editPost', '', '编辑文章分类提交', ''),
(135, 1, 'portal', 'admin_url', 'portal/AdminCategory/select', '', '文章分类选择对话框', ''),
(136, 1, 'portal', 'admin_url', 'portal/AdminCategory/listOrder', '', '文章分类排序', ''),
(137, 1, 'portal', 'admin_url', 'portal/AdminCategory/delete', '', '删除文章分类', ''),
(138, 1, 'portal', 'admin_url', 'portal/AdminIndex/default', '', '门户管理', ''),
(139, 1, 'portal', 'admin_url', 'portal/AdminPage/index', '', '页面管理', ''),
(140, 1, 'portal', 'admin_url', 'portal/AdminPage/add', '', '添加页面', ''),
(141, 1, 'portal', 'admin_url', 'portal/AdminPage/addPost', '', '添加页面提交', ''),
(142, 1, 'portal', 'admin_url', 'portal/AdminPage/edit', '', '编辑页面', ''),
(143, 1, 'portal', 'admin_url', 'portal/AdminPage/editPost', '', '编辑页面提交', ''),
(144, 1, 'portal', 'admin_url', 'portal/AdminPage/delete', '', '删除页面', ''),
(145, 1, 'portal', 'admin_url', 'portal/AdminTag/index', '', '文章标签', ''),
(146, 1, 'portal', 'admin_url', 'portal/AdminTag/add', '', '添加文章标签', ''),
(147, 1, 'portal', 'admin_url', 'portal/AdminTag/addPost', '', '添加文章标签提交', ''),
(148, 1, 'portal', 'admin_url', 'portal/AdminTag/upStatus', '', '更新标签状态', ''),
(149, 1, 'portal', 'admin_url', 'portal/AdminTag/delete', '', '删除文章标签', ''),
(150, 1, 'user', 'admin_url', 'user/AdminAsset/index', '', '资源管理', ''),
(151, 1, 'user', 'admin_url', 'user/AdminAsset/delete', '', '删除文件', ''),
(152, 1, 'user', 'admin_url', 'user/AdminIndex/default', '', '角色管理', ''),
(153, 1, 'user', 'admin_url', 'user/AdminIndex/default1', '', '用户组', ''),
(154, 1, 'user', 'admin_url', 'user/AdminIndex/index', '', '本站用户', ''),
(155, 1, 'user', 'admin_url', 'user/AdminIndex/ban', '', '本站用户拉黑', ''),
(156, 1, 'user', 'admin_url', 'user/AdminIndex/cancelBan', '', '本站用户启用', ''),
(157, 1, 'user', 'admin_url', 'user/AdminOauth/index', '', '第三方用户', ''),
(158, 1, 'user', 'admin_url', 'user/AdminOauth/delete', '', '删除第三方用户绑定', ''),
(159, 1, 'user', 'admin_url', 'user/AdminUserAction/index', '', '用户操作管理', ''),
(160, 1, 'user', 'admin_url', 'user/AdminUserAction/edit', '', '编辑用户操作', ''),
(161, 1, 'user', 'admin_url', 'user/AdminUserAction/editPost', '', '编辑用户操作提交', ''),
(162, 1, 'user', 'admin_url', 'user/AdminUserAction/sync', '', '同步用户操作', ''),
(163, 1, 'plugin/Wxapp', 'plugin_url', 'plugin/Wxapp/AdminIndex/index', '', '小程序管理', ''),
(164, 1, 'plugin/Wxapp', 'plugin_url', 'plugin/Wxapp/AdminWxapp/add', '', '添加小程序', ''),
(165, 1, 'plugin/Wxapp', 'plugin_url', 'plugin/Wxapp/AdminWxapp/addPost', '', '添加小程序提交保存', ''),
(166, 1, 'plugin/Wxapp', 'plugin_url', 'plugin/Wxapp/AdminWxapp/edit', '', '编辑小程序', ''),
(167, 1, 'plugin/Wxapp', 'plugin_url', 'plugin/Wxapp/AdminWxapp/editPost', '', '编辑小程序提交保存', ''),
(168, 1, 'plugin/Wxapp', 'plugin_url', 'plugin/Wxapp/AdminWxapp/delete', '', '删除小程序', ''),
(169, 1, 'frame', 'admin_url', 'frame/AdminIndex/default', '', '组织架构管理', ''),
(170, 1, 'frame', 'admin_url', 'frame/AdminIndex/index', '', '组织架构管理', ''),
(171, 1, 'vague', 'admin_url', 'vague/AdminIndex/index', '', '模糊岗位管理', ''),
(172, 1, 'identity', 'admin_url', 'identity/AdminIndex/index', '', '员工身份管理', ''),
(173, 1, 'role', 'admin_url', 'role/AdminIndex/index', '', '员工角色管理', ''),
(174, 1, 'seal', 'admin_url', 'seal/AdminIndex/index', '', '行政公章管理', ''),
(175, 1, 'protocol', 'admin_url', 'protocol/AdminIndex/index', '', '协议管理', ''),
(176, 1, 'protocol', 'admin_url', 'protocol/AdminCategory/index', '', '协议模板管理', '');

-- --------------------------------------------------------

--
-- 表的结构 `so_comment`
--

CREATE TABLE `so_comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '被回复的评论id',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发表评论的用户id',
  `to_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '被评论的用户id',
  `object_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论内容 id',
  `like_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点赞数',
  `dislike_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '不喜欢数',
  `floor` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '楼层数',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论时间',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:已审核,0:未审核',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '评论类型；1实名评论',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '评论内容所在表，不带表前缀',
  `full_name` varchar(50) NOT NULL DEFAULT '' COMMENT '评论者昵称',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '评论者邮箱',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系',
  `url` text COMMENT '原文地址',
  `content` text CHARACTER SET utf8mb4 COMMENT '评论内容',
  `more` text CHARACTER SET utf8mb4 COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

-- --------------------------------------------------------

--
-- 表的结构 `so_frame_category`
--

CREATE TABLE `so_frame_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_frame_category`
--

INSERT INTO `so_frame_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`) VALUES
(1, 0, 0, 1, 1540720526, 6, 'test1', '', '0-1', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(2, 1, 0, 1, 1540720523, 2, 'test24', '', '0-1-2', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(3, 0, 0, 1, 0, 3, '董事', '', '0-3', '', '', '', '', '', '{\"thumbnail\":\"\"}'),
(4, 0, 0, 0, 1540720516, 4, 'test5', '', '0-4', '', '', '', '', '', '{\"thumbnail\":\"\"}'),
(5, 0, 0, 1, 1540719955, 10000, 'test6', '', '0-5', '', '', '', '', '', NULL),
(6, 3, 0, 0, 1540719949, 10000, 'test7', '', '0-3-6', '', '', '', '', '', NULL),
(7, 3, 0, 1, 0, 10000, '行政部', '', '0-3-7', '', '', '', '', '', NULL),
(8, 3, 0, 1, 0, 10000, '财务部', '', '0-3-8', '', '', '', '', '', NULL),
(9, 7, 0, 1, 0, 10000, '行政助理', '', '0-3-7-9', '', '', '', '', '', '{\"thumbnail\":\"seal\\/20181120\\/e42b25bf3da4c4d4244adebdb7c53fee.png\"}'),
(10, 8, 0, 1, 0, 10000, '财务助理', '', '0-3-8-10', '', '', '', '', '', '{\"thumbnail\":\"seal\\/20181120\\/e42b25bf3da4c4d4244adebdb7c53fee.png\"}');

-- --------------------------------------------------------

--
-- 表的结构 `so_frame_category_post`
--

CREATE TABLE `so_frame_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_frame_category_post`
--

INSERT INTO `so_frame_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(5, 5, 3, 10000, 1),
(6, 3, 0, 10000, 1),
(7, 8, 8, 10000, 1),
(8, 9, 7, 10000, 1),
(9, 9, 8, 10000, 1),
(10, 10, 7, 10000, 1),
(12, 11, 3, 10000, 1),
(13, 12, 10, 10000, 1),
(14, 13, 7, 10000, 1),
(15, 14, 0, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_frame_category_resp_post`
--

CREATE TABLE `so_frame_category_resp_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单位/部门负责人表';

--
-- 转存表中的数据 `so_frame_category_resp_post`
--

INSERT INTO `so_frame_category_resp_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(3, 13, 10, 10000, 1),
(4, 14, 9, 10000, 1),
(5, 11, 0, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_frame_category_secr_post`
--

CREATE TABLE `so_frame_category_secr_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_frame_category_secr_post`
--

INSERT INTO `so_frame_category_secr_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(1, 13, 10, 10000, 1),
(2, 13, 8, 10000, 1),
(3, 14, 8, 10000, 1),
(4, 11, 0, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_hook`
--

CREATE TABLE `so_hook` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '钩子类型(1:系统钩子;2:应用钩子;3:模板钩子;4:后台模板钩子)',
  `once` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否只允许一个插件运行(0:多个;1:一个)',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `hook` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子',
  `app` varchar(15) NOT NULL DEFAULT '' COMMENT '应用名(只有应用钩子才用)',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统钩子表';

--
-- 转存表中的数据 `so_hook`
--

INSERT INTO `so_hook` (`id`, `type`, `once`, `name`, `hook`, `app`, `description`) VALUES
(1, 1, 0, '应用初始化', 'app_init', 'cmf', '应用初始化'),
(2, 1, 0, '应用开始', 'app_begin', 'cmf', '应用开始'),
(3, 1, 0, '模块初始化', 'module_init', 'cmf', '模块初始化'),
(4, 1, 0, '控制器开始', 'action_begin', 'cmf', '控制器开始'),
(5, 1, 0, '视图输出过滤', 'view_filter', 'cmf', '视图输出过滤'),
(6, 1, 0, '应用结束', 'app_end', 'cmf', '应用结束'),
(7, 1, 0, '日志write方法', 'log_write', 'cmf', '日志write方法'),
(8, 1, 0, '输出结束', 'response_end', 'cmf', '输出结束'),
(9, 1, 0, '后台控制器初始化', 'admin_init', 'cmf', '后台控制器初始化'),
(10, 1, 0, '前台控制器初始化', 'home_init', 'cmf', '前台控制器初始化'),
(11, 1, 1, '发送手机验证码', 'send_mobile_verification_code', 'cmf', '发送手机验证码'),
(12, 3, 0, '模板 body标签开始', 'body_start', '', '模板 body标签开始'),
(13, 3, 0, '模板 head标签结束前', 'before_head_end', '', '模板 head标签结束前'),
(14, 3, 0, '模板底部开始', 'footer_start', '', '模板底部开始'),
(15, 3, 0, '模板底部开始之前', 'before_footer', '', '模板底部开始之前'),
(16, 3, 0, '模板底部结束之前', 'before_footer_end', '', '模板底部结束之前'),
(17, 3, 0, '模板 body 标签结束之前', 'before_body_end', '', '模板 body 标签结束之前'),
(18, 3, 0, '模板左边栏开始', 'left_sidebar_start', '', '模板左边栏开始'),
(19, 3, 0, '模板左边栏结束之前', 'before_left_sidebar_end', '', '模板左边栏结束之前'),
(20, 3, 0, '模板右边栏开始', 'right_sidebar_start', '', '模板右边栏开始'),
(21, 3, 0, '模板右边栏结束之前', 'before_right_sidebar_end', '', '模板右边栏结束之前'),
(22, 3, 1, '评论区', 'comment', '', '评论区'),
(23, 3, 1, '留言区', 'guestbook', '', '留言区'),
(24, 2, 0, '后台首页仪表盘', 'admin_dashboard', 'admin', '后台首页仪表盘'),
(25, 4, 0, '后台模板 head标签结束前', 'admin_before_head_end', '', '后台模板 head标签结束前'),
(26, 4, 0, '后台模板 body 标签结束之前', 'admin_before_body_end', '', '后台模板 body 标签结束之前'),
(27, 2, 0, '后台登录页面', 'admin_login', 'admin', '后台登录页面'),
(28, 1, 1, '前台模板切换', 'switch_theme', 'cmf', '前台模板切换'),
(29, 3, 0, '主要内容之后', 'after_content', '', '主要内容之后'),
(30, 2, 0, '文章显示之前', 'portal_before_assign_article', 'portal', '文章显示之前'),
(31, 2, 0, '后台文章保存之后', 'portal_admin_after_save_article', 'portal', '后台文章保存之后'),
(32, 2, 1, '获取上传界面', 'fetch_upload_view', 'user', '获取上传界面'),
(33, 3, 0, '主要内容之前', 'before_content', 'cmf', '主要内容之前'),
(34, 1, 0, '日志写入完成', 'log_write_done', 'cmf', '日志写入完成'),
(35, 1, 1, '后台模板切换', 'switch_admin_theme', 'cmf', '后台模板切换'),
(36, 1, 1, '验证码图片', 'captcha_image', 'cmf', '验证码图片'),
(37, 2, 1, '后台模板设计界面', 'admin_theme_design_view', 'admin', '后台模板设计界面'),
(38, 2, 1, '后台设置网站信息界面', 'admin_setting_site_view', 'admin', '后台设置网站信息界面'),
(39, 2, 1, '后台清除缓存界面', 'admin_setting_clear_cache_view', 'admin', '后台清除缓存界面'),
(40, 2, 1, '后台导航管理界面', 'admin_nav_index_view', 'admin', '后台导航管理界面'),
(41, 2, 1, '后台友情链接管理界面', 'admin_link_index_view', 'admin', '后台友情链接管理界面'),
(42, 2, 1, '后台幻灯片管理界面', 'admin_slide_index_view', 'admin', '后台幻灯片管理界面'),
(43, 2, 1, '后台管理员列表界面', 'admin_user_index_view', 'admin', '后台管理员列表界面'),
(44, 2, 1, '后台角色管理界面', 'admin_rbac_index_view', 'admin', '后台角色管理界面'),
(45, 2, 1, '门户后台文章管理列表界面', 'portal_admin_article_index_view', 'portal', '门户后台文章管理列表界面'),
(46, 2, 1, '门户后台文章分类管理列表界面', 'portal_admin_category_index_view', 'portal', '门户后台文章分类管理列表界面'),
(47, 2, 1, '门户后台页面管理列表界面', 'portal_admin_page_index_view', 'portal', '门户后台页面管理列表界面'),
(48, 2, 1, '门户后台文章标签管理列表界面', 'portal_admin_tag_index_view', 'portal', '门户后台文章标签管理列表界面'),
(49, 2, 1, '用户管理本站用户列表界面', 'user_admin_index_view', 'user', '用户管理本站用户列表界面'),
(50, 2, 1, '资源管理列表界面', 'user_admin_asset_index_view', 'user', '资源管理列表界面'),
(51, 2, 1, '用户管理第三方用户列表界面', 'user_admin_oauth_index_view', 'user', '用户管理第三方用户列表界面'),
(52, 2, 1, '后台首页界面', 'admin_index_index_view', 'admin', '后台首页界面'),
(53, 2, 1, '后台回收站界面', 'admin_recycle_bin_index_view', 'admin', '后台回收站界面'),
(54, 2, 1, '后台菜单管理界面', 'admin_menu_index_view', 'admin', '后台菜单管理界面'),
(55, 2, 1, '后台自定义登录是否开启钩子', 'admin_custom_login_open', 'admin', '后台自定义登录是否开启钩子'),
(56, 4, 0, '门户后台文章添加编辑界面右侧栏', 'portal_admin_article_edit_view_right_sidebar', 'portal', '门户后台文章添加编辑界面右侧栏'),
(57, 4, 0, '门户后台文章添加编辑界面主要内容', 'portal_admin_article_edit_view_main', 'portal', '门户后台文章添加编辑界面主要内容'),
(58, 2, 1, '门户后台文章添加界面', 'portal_admin_article_add_view', 'portal', '门户后台文章添加界面'),
(59, 2, 1, '门户后台文章编辑界面', 'portal_admin_article_edit_view', 'portal', '门户后台文章编辑界面'),
(60, 2, 1, '门户后台文章分类添加界面', 'portal_admin_category_add_view', 'portal', '门户后台文章分类添加界面'),
(61, 2, 1, '门户后台文章分类编辑界面', 'portal_admin_category_edit_view', 'portal', '门户后台文章分类编辑界面'),
(62, 2, 1, '门户后台页面添加界面', 'portal_admin_page_add_view', 'portal', '门户后台页面添加界面'),
(63, 2, 1, '门户后台页面编辑界面', 'portal_admin_page_edit_view', 'portal', '门户后台页面编辑界面'),
(64, 2, 1, '后台幻灯片页面列表界面', 'admin_slide_item_index_view', 'admin', '后台幻灯片页面列表界面'),
(65, 2, 1, '后台幻灯片页面添加界面', 'admin_slide_item_add_view', 'admin', '后台幻灯片页面添加界面'),
(66, 2, 1, '后台幻灯片页面编辑界面', 'admin_slide_item_edit_view', 'admin', '后台幻灯片页面编辑界面'),
(67, 2, 1, '后台管理员添加界面', 'admin_user_add_view', 'admin', '后台管理员添加界面'),
(68, 2, 1, '后台管理员编辑界面', 'admin_user_edit_view', 'admin', '后台管理员编辑界面'),
(69, 2, 1, '后台角色添加界面', 'admin_rbac_role_add_view', 'admin', '后台角色添加界面'),
(70, 2, 1, '后台角色编辑界面', 'admin_rbac_role_edit_view', 'admin', '后台角色编辑界面'),
(71, 2, 1, '后台角色授权界面', 'admin_rbac_authorize_view', 'admin', '后台角色授权界面');

-- --------------------------------------------------------

--
-- 表的结构 `so_hook_plugin`
--

CREATE TABLE `so_hook_plugin` (
  `id` int(10) UNSIGNED NOT NULL,
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
  `hook` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名',
  `plugin` varchar(50) NOT NULL DEFAULT '' COMMENT '插件'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统钩子插件表';

-- --------------------------------------------------------

--
-- 表的结构 `so_identity_category`
--

CREATE TABLE `so_identity_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_identity_category`
--

INSERT INTO `so_identity_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`) VALUES
(1, 0, 0, 1, 0, 10000, '全民', '', '0-1', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(2, 1, 0, 0, 1540720976, 10000, 'test2', '', '0-1-2', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(3, 0, 0, 1, 0, 10000, '集体', '', '0-3', '', '', '', '', '', NULL),
(4, 0, 0, 1, 0, 10000, '农电', '', '0-4', '', '', '', '', '', NULL),
(5, 0, 0, 1, 0, 10000, '外聘', '', '0-5', '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_identity_category_post`
--

CREATE TABLE `so_identity_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_identity_category_post`
--

INSERT INTO `so_identity_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(1, 5, 0, 10000, 1),
(2, 5, 1, 10000, 1),
(3, 3, 0, 10000, 1),
(4, 9, 4, 10000, 1),
(5, 10, 4, 10000, 1),
(6, 11, 0, 10000, 1),
(7, 11, 0, 10000, 1),
(8, 11, 0, 10000, 1),
(9, 11, 0, 10000, 1),
(10, 12, 0, 10000, 1),
(11, 13, 0, 10000, 1),
(12, 13, 0, 10000, 1),
(13, 13, 0, 10000, 1),
(14, 14, 0, 10000, 1),
(15, 11, 0, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_link`
--

CREATE TABLE `so_link` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:不显示',
  `rating` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接评级',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接描述',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接地址',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '友情链接图标',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '友情链接打开方式',
  `rel` varchar(50) NOT NULL DEFAULT '' COMMENT '链接与网站的关系'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='友情链接表';

--
-- 转存表中的数据 `so_link`
--

INSERT INTO `so_link` (`id`, `status`, `rating`, `list_order`, `description`, `url`, `name`, `image`, `target`, `rel`) VALUES
(1, 1, 1, 8, 'thinkcmf官网', 'http://www.thinkcmf.com', 'ThinkCMF', '', '_blank', '');

-- --------------------------------------------------------

--
-- 表的结构 `so_nav`
--

CREATE TABLE `so_nav` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_main` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否为主导航;1:是;0:不是',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '导航位置名称',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台导航位置表';

--
-- 转存表中的数据 `so_nav`
--

INSERT INTO `so_nav` (`id`, `is_main`, `name`, `remark`) VALUES
(1, 1, '主导航', '主导航'),
(2, 0, '底部导航', '');

-- --------------------------------------------------------

--
-- 表的结构 `so_nav_menu`
--

CREATE TABLE `so_nav_menu` (
  `id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL COMMENT '导航 id',
  `parent_id` int(11) NOT NULL COMMENT '父 id',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:显示;0:隐藏',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '打开方式',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
  `icon` varchar(20) NOT NULL DEFAULT '' COMMENT '图标',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '层级关系'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='前台导航菜单表';

--
-- 转存表中的数据 `so_nav_menu`
--

INSERT INTO `so_nav_menu` (`id`, `nav_id`, `parent_id`, `status`, `list_order`, `name`, `target`, `href`, `icon`, `path`) VALUES
(1, 1, 0, 1, 0, '首页', '', 'home', '', '0-1');

-- --------------------------------------------------------

--
-- 表的结构 `so_option`
--

CREATE TABLE `so_option` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `autoload` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否自动加载;1:自动加载;0:不自动加载',
  `option_name` varchar(64) NOT NULL DEFAULT '' COMMENT '配置名',
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '配置值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='全站配置表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `so_option`
--

INSERT INTO `so_option` (`id`, `autoload`, `option_name`, `option_value`) VALUES
(1, 1, 'site_info', '{\"site_name\":\"\\u5728\\u7ebf\\u7b7e\\u7ea6\\u7cfb\\u7edf\",\"site_seo_title\":\"\\u5728\\u7ebf\\u7b7e\\u7ea6\\u7cfb\\u7edf\",\"site_seo_keywords\":\"\",\"site_seo_description\":\"\",\"site_icp\":\"\",\"site_gwa\":\"\",\"site_admin_email\":\"\",\"site_analytics\":\"\"}'),
(2, 1, 'cmf_settings', '{\"open_registration\":\"1\",\"banned_usernames\":\"\"}'),
(3, 1, 'cdn_settings', '{\"cdn_static_root\":\"\"}'),
(4, 1, 'admin_settings', '{\"admin_password\":\"\",\"admin_style\":\"flatadmin\"}'),
(5, 1, 'wxapp_settings', '{\"default\":{\"name\":\"\\u5728\\u7ebf\\u7b7e\\u7ea6\\u7cfb\\u7edf\",\"app_id\":\"wx6cc7078c98091722\",\"app_secret\":\"00000\",\"is_default\":\"1\",\"_plugin\":\"wxapp\",\"_controller\":\"admin_wxapp\",\"_action\":\"addpost\"},\"wxapps\":{\"wx6cc7078c98091722\":{\"name\":\"\\u5728\\u7ebf\\u7b7e\\u7ea6\\u7cfb\\u7edf\",\"app_id\":\"wx6cc7078c98091722\",\"app_secret\":\"00000\",\"_plugin\":\"wxapp\",\"_controller\":\"admin_wxapp\",\"_action\":\"addpost\"}}}');

-- --------------------------------------------------------

--
-- 表的结构 `so_plugin`
--

CREATE TABLE `so_plugin` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '自增id',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '插件类型;1:网站;8:微信',
  `has_admin` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否有后台管理,0:没有;1:有',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:开启;0:禁用',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '插件安装时间',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '插件标识名,英文字母(惟一)',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件名称',
  `demo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '演示地址，带协议',
  `hooks` varchar(255) NOT NULL DEFAULT '' COMMENT '实现的钩子;以“,”分隔',
  `author` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '插件作者',
  `author_url` varchar(50) NOT NULL DEFAULT '' COMMENT '作者网站链接',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '插件版本号',
  `description` varchar(255) NOT NULL COMMENT '插件描述',
  `config` text COMMENT '插件配置'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='插件表';

--
-- 转存表中的数据 `so_plugin`
--

INSERT INTO `so_plugin` (`id`, `type`, `has_admin`, `status`, `create_time`, `name`, `title`, `demo_url`, `hooks`, `author`, `author_url`, `version`, `description`, `config`) VALUES
(1, 1, 1, 1, 0, 'Wxapp', '微信小程序', 'http://demo.thinkcmf.com', '', 'ThinkCMF', 'http://www.thinkcmf.com', '1.0', '微信小程序管理工具', '[]');

-- --------------------------------------------------------

--
-- 表的结构 `so_portal_category`
--

CREATE TABLE `so_portal_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_portal_category`
--

INSERT INTO `so_portal_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`) VALUES
(1, 0, 0, 1, 0, 10000, 'test1', '', '0-1', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(2, 1, 0, 1, 0, 10000, 'test2', '', '0-1-2', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}');

-- --------------------------------------------------------

--
-- 表的结构 `so_portal_category_post`
--

CREATE TABLE `so_portal_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_portal_category_post`
--

INSERT INTO `so_portal_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(2, 1, 1, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_portal_post`
--

CREATE TABLE `so_portal_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id',
  `post_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '类型,1:文章;2:页面',
  `post_format` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '内容格式;1:html;2:md',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发表者用户id',
  `post_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:已发布;0:未发布;',
  `comment_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '评论状态;1:允许;0:不允许',
  `is_top` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否置顶;1:置顶;0:不置顶',
  `recommended` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_hits` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '查看数',
  `post_favorites` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '收藏数',
  `post_like` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点赞数',
  `comment_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `published_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发布时间',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `post_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'post标题',
  `post_keywords` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo keywords',
  `post_excerpt` varchar(500) NOT NULL DEFAULT '' COMMENT 'post摘要',
  `post_source` varchar(150) NOT NULL DEFAULT '' COMMENT '转载文章的来源',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `post_content` text COMMENT '文章内容',
  `post_content_filtered` text COMMENT '处理过的文章内容',
  `more` text COMMENT '扩展属性,如缩略图;格式为json'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `so_portal_post`
--

INSERT INTO `so_portal_post` (`id`, `parent_id`, `post_type`, `post_format`, `user_id`, `post_status`, `comment_status`, `is_top`, `recommended`, `post_hits`, `post_favorites`, `post_like`, `comment_count`, `create_time`, `update_time`, `published_time`, `delete_time`, `post_title`, `post_keywords`, `post_excerpt`, `post_source`, `thumbnail`, `post_content`, `post_content_filtered`, `more`) VALUES
(1, 0, 1, 1, 1, 1, 1, 0, 0, 13, 0, 0, 0, 1540823466, 1541234241, 1540823400, 0, 'test', '', '', '', '', '&lt;p&gt;123&lt;/p&gt;', NULL, '{\"audio\":\"\",\"video\":\"\",\"thumbnail\":\"\",\"template\":\"\"}');

-- --------------------------------------------------------

--
-- 表的结构 `so_portal_tag`
--

CREATE TABLE `so_portal_tag` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `recommended` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '标签文章数',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章标签表';

-- --------------------------------------------------------

--
-- 表的结构 `so_portal_tag_post`
--

CREATE TABLE `so_portal_tag_post` (
  `id` bigint(20) NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '标签 id',
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章 id',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 标签文章对应表';

-- --------------------------------------------------------

--
-- 表的结构 `so_protocol_category`
--

CREATE TABLE `so_protocol_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` longtext COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性',
  `mode_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_protocol_category`
--

INSERT INTO `so_protocol_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`, `mode_type`) VALUES
(11, 0, 0, 1, 1542987193, 10000, 'test', NULL, '0-11', '', '', '', '', '', '{\"axes\":[{\"page\":\"2\",\"sign\":\"140,46\",\"time\":\"140,80\"}],\"seal\":{\"page\":\"2\",\"sign\":\"100,100\"},\"files\":[{\"url\":\"protocol\\/20181120\\/1ff3910f4e0f1f9c0038491cba41b94e.doc\",\"name\":\"国网浙江省电力有限公司保密工作责任书（通用部门）.doc\"}]}', 0),
(12, 0, 0, 1, 1543149982, 10000, 'test', NULL, '0-12', '', '', '', '', '', '{\"axes\":[{\"page\":5,\"sign\":\"140,46\",\"time\":\"140,80\"}],\"seal\":[{\"page\":5,\"sign\":\"140,56\"}],\"files\":[{\"url\":\"protocol\\/20181125\\/7572c233aa90fab605504ec89bab1f99.doc\",\"name\":\"737fb6782eeb3f04815d5f6946be2579.doc\"}]}', 0),
(13, 0, 0, 1, 1543509014, 10000, 'test', NULL, '0-13', '', '', '', '', '', '{\"axes\":[{\"page\":5,\"sign\":\"140,46\",\"time\":\"140,80\"}],\"seal\":{\"page\":5,\"sign\":\"140,56\"},\"files\":[{\"url\":\"protocol\\/20181125\\/ca23f8da1118116d6d84783fee9f527a.doc\",\"name\":\"0197480755757d084f48ed2589b2c8f4 (2).doc\"}]}', 0),
(14, 0, 0, 1, 0, 10000, '保密工作责任书', NULL, '0-14', '', '', '', '', '', '{\"axes\":[{\"page\":5,\"sign\":\"140,46\",\"time\":\"140,80\"}],\"seal\":{\"page\":\"5\",\"sign\":\"140,56\"},\"frame\":{\"page\":\"1\",\"sign\":\"140,46\"},\"files\":[{\"url\":\"protocol\\/20181130\\/9f5547026c59bd24a06c192af74dd462.doc\",\"name\":\"国网浙江省电力有限公司保密工作责任书（通用部门）.doc\"}]}', 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_protocol_category_post`
--

CREATE TABLE `so_protocol_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_protocol_category_post`
--

INSERT INTO `so_protocol_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(4, 1, 5, 10000, 1),
(6, 3, 3, 10000, 1),
(8, 2, 6, 10000, 1),
(9, 4, 1, 10000, 1),
(10, 5, 1, 10000, 1),
(11, 6, 0, 10000, 1),
(12, 7, 1, 10000, 1),
(13, 8, 1, 10000, 1),
(14, 9, 11, 10000, 1),
(15, 10, 11, 10000, 1),
(39, 27, 14, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_protocol_category_seal_post`
--

CREATE TABLE `so_protocol_category_seal_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布',
  `place` varchar(32) NOT NULL DEFAULT '公章占位符1' COMMENT '占位符标识'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_protocol_category_seal_post`
--

INSERT INTO `so_protocol_category_seal_post` (`id`, `post_id`, `category_id`, `list_order`, `status`, `place`) VALUES
(2, 1, 1, 10000, 1, '公章占位符1'),
(3, 3, 3, 10000, 1, '公章占位符1'),
(65, 2, 1, 10000, 1, '公章占位符1'),
(66, 2, 3, 10000, 1, '公章占位符1'),
(67, 4, 1, 10000, 1, '公章占位符1'),
(68, 5, 4, 10000, 1, '公章占位符1'),
(69, 6, 4, 10000, 1, '公章占位符1'),
(70, 7, 4, 10000, 1, '公章占位符1'),
(71, 8, 3, 10000, 1, '公章占位符1'),
(72, 9, 3, 10000, 1, '公章占位符1'),
(73, 10, 4, 10000, 1, '公章占位符1'),
(109, 27, 1, 10000, 1, '公章占位符1');

-- --------------------------------------------------------

--
-- 表的结构 `so_protocol_category_user_post`
--

CREATE TABLE `so_protocol_category_user_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `frame` varchar(32) DEFAULT '0' COMMENT '所属组织架构',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布',
  `sign_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '签约状态：-1签约失败，0待签约，1-待审核，2-已签约',
  `sign_url` varchar(256) DEFAULT NULL COMMENT '签约图片地址',
  `notes` varchar(256) DEFAULT NULL COMMENT '备注',
  `place` varchar(32) NOT NULL DEFAULT '0' COMMENT '签名占位符',
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_protocol_category_user_post`
--

INSERT INTO `so_protocol_category_user_post` (`id`, `post_id`, `category_id`, `frame`, `list_order`, `status`, `sign_status`, `sign_url`, `notes`, `place`, `update_time`) VALUES
(114, 27, 14, '0', 10000, 1, 0, NULL, NULL, '0', NULL),
(115, 27, 13, '0', 10000, 1, 0, NULL, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_protocol_post`
--

CREATE TABLE `so_protocol_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级id',
  `post_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '类型,1:文章;2:页面',
  `post_format` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '内容格式;1:html;2:md',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发表者用户id',
  `post_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:已发布;0:未发布;',
  `comment_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '评论状态;1:允许;0:不允许',
  `is_top` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否置顶;1:置顶;0:不置顶',
  `recommended` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否推荐;1:推荐;0:不推荐',
  `post_hits` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '查看数',
  `post_favorites` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '收藏数',
  `post_like` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '点赞数',
  `comment_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `published_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发布时间',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `post_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'post标题',
  `post_keywords` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo keywords',
  `post_excerpt` varchar(500) NOT NULL DEFAULT '' COMMENT 'post摘要',
  `post_source` varchar(150) NOT NULL DEFAULT '' COMMENT '转载文章的来源',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `post_content` text COMMENT '文章内容',
  `post_content_filtered` text COMMENT '处理过的文章内容',
  `more` text COMMENT '扩展属性,如缩略图;格式为json',
  `post_count` int(11) DEFAULT NULL COMMENT '签约数量',
  `sign_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '签约状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章表' ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `so_protocol_post`
--

INSERT INTO `so_protocol_post` (`id`, `parent_id`, `post_type`, `post_format`, `user_id`, `post_status`, `comment_status`, `is_top`, `recommended`, `post_hits`, `post_favorites`, `post_like`, `comment_count`, `create_time`, `update_time`, `published_time`, `delete_time`, `post_title`, `post_keywords`, `post_excerpt`, `post_source`, `thumbnail`, `post_content`, `post_content_filtered`, `more`, `post_count`, `sign_status`) VALUES
(1, 0, 1, 1, 1, 1, 1, 0, 0, 148, 0, 0, 0, 1540823466, 1542037931, 1540823400, 1542644841, '广东广州XXXXXXX科技有限公司离岗保密承诺书', '5', '', '', '', '\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size: 36px; font-family: 宋体, SimSun;&quot;&gt;xxxx有限公司&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size: 24px; font-family: 宋体, SimSun;&quot;&gt;涉密人员离岗保密承诺书&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size: 24px; font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 24px; font-family: 仿宋_GB2312;&quot;&gt;&lt;span style=&quot;font-size: 24px; font-family: 仿宋_GB2312;&quot;&gt;（&lt;/span&gt;201&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 24px; font-family: 仿宋_GB2312;&quot;&gt;8&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 24px; font-family: 仿宋_GB2312;&quot;&gt;年度）&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt;         &lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;部门：&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt;           &lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt;   201&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt;7&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 29px;&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;年&lt;/span&gt;12月&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px&quot;&gt;&lt;span style=&quot;font-size: 21px; font-family: 宋体, SimSun;&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;vertical-align: baseline; line-height: 37px; text-align: left; text-indent: 0em;&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt;&lt;br style=&quot;page-break-before:always&quot;&gt;        &lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;本人了解国家和公司有关保密法规制度，知悉应当承担的保密义务和法律责任。本人庄重承诺：&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;一、认真遵守国家保密法律、法规和公司保密规章制度，履行保密义务；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;二、不以任何方式泄露在公司工作期间接触和知悉的国家秘密和企业秘密；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;三、已全部清退不应由个人持有的各类国家秘密和企业秘密载体（包括纸介质、磁介质、光介质等涉密载体）；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;四、未经公司审查批准，不擅自发表涉及公司未公开工作内容的文章、著述等；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;&lt;strong&gt;五、已认真核实&lt;/strong&gt;&lt;strong&gt;本工作&lt;/strong&gt;&lt;strong&gt;岗位&lt;/strong&gt;&lt;strong&gt;涉密事项，并严格按有关保密规定进行交接。&lt;/strong&gt;&lt;strong&gt;情况&lt;/strong&gt;&lt;strong&gt;如下：&lt;/strong&gt;&lt;/span&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px;&quot;&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-size: 18px; font-family: 仿宋_GB2312;&quot;&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;table width=&quot;574&quot;&gt;&lt;tbody&gt;\n&lt;tr style=&quot;height:74px&quot; class=&quot;firstRow&quot;&gt;\n&lt;td width=&quot;253&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-color: windowtext; border-style: solid;&quot;&gt;&lt;p style=&quot;text-align:center;line-height:33px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;涉密事项、载体&lt;/span&gt;&lt;/p&gt;&lt;/td&gt;\n&lt;td width=&quot;151&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: windowtext; border-bottom-color: windowtext;&quot;&gt;\n&lt;p style=&quot;text-align:center;line-height:33px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;交接、清退情况&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center;line-height:33px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;（是/否）&lt;/span&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;td width=&quot;76&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: windowtext; border-bottom-color: windowtext;&quot;&gt;&lt;p style=&quot;text-align:center;line-height:33px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;交接人&lt;/span&gt;&lt;/p&gt;&lt;/td&gt;\n&lt;td width=&quot;94&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: windowtext; border-bottom-color: windowtext;&quot;&gt;&lt;p style=&quot;text-align:center;line-height:33px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;交接时间&lt;/span&gt;&lt;/p&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height:74px&quot;&gt;\n&lt;td width=&quot;253&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-left-color: windowtext; border-right-color: windowtext; border-style: solid; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;151&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;76&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;94&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height:74px&quot;&gt;\n&lt;td width=&quot;253&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-left-color: windowtext; border-right-color: windowtext; border-style: solid; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;151&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;76&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;94&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height:74px&quot;&gt;\n&lt;td width=&quot;253&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-left-color: windowtext; border-right-color: windowtext; border-style: solid; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;151&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;76&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;94&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr style=&quot;height:74px&quot;&gt;\n&lt;td width=&quot;253&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-left-color: windowtext; border-right-color: windowtext; border-style: solid; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;151&quot; valign=&quot;center&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;76&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;td width=&quot;94&quot; valign=&quot;top&quot; style=&quot;padding: 0px 7px; border-width: 1px; border-style: solid; border-left-color: initial; border-right-color: windowtext; border-top-color: initial; border-bottom-color: windowtext;&quot;&gt;&lt;br&gt;&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;&lt;/table&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;六、脱密管理&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;（一）离退休人员&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:48px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun;&quot;&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;自愿接受脱密期管理，自&lt;/span&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; letter-spacing: 1px;&quot;&gt;  2012  &lt;/span&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;年&lt;/span&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; letter-spacing: 1px;&quot;&gt;  11  &lt;/span&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;月&lt;/span&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; letter-spacing: 1px;&quot;&gt;  1  &lt;/span&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;日&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;至&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312; font-size: 16px; text-decoration: underline;&quot;&gt;  2018  &lt;/span&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;年&lt;/span&gt;&lt;span style=&quot;text-decoration-line: underline; font-family: 仿宋_GB2312;&quot;&gt;  9  &lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;月&lt;/span&gt;&lt;span style=&quot;text-decoration-line: underline; font-family: 仿宋_GB2312;&quot;&gt;  30  &lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;日服从有关部门的保密监管。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;（二）离岗人员&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:48px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;自愿接受脱密期管理，自&lt;/span&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; letter-spacing: 1px;&quot;&gt;    &lt;/span&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;年&lt;/span&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; letter-spacing: 1px;&quot;&gt;    &lt;/span&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;月&lt;/span&gt;&lt;span style=&quot;text-decoration: underline; font-family: 仿宋_GB2312; letter-spacing: 1px;&quot;&gt;    &lt;/span&gt;&lt;span style=&quot;letter-spacing: 1px; font-family: 仿宋_GB2312;&quot;&gt;日&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;至&lt;/span&gt;&lt;span style=&quot;text-decoration-line: underline; font-family: 仿宋_GB2312;&quot;&gt;    &lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;年&lt;/span&gt;&lt;span style=&quot;text-decoration-line: underline; font-family: 仿宋_GB2312;&quot;&gt;    &lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;月&lt;/span&gt;&lt;span style=&quot;text-decoration-line: underline; font-family: 仿宋_GB2312;&quot;&gt;    &lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;日服从有关部门的保密监管。在脱密期内拟从事&lt;/span&gt;&lt;span style=&quot;text-decoration-line: underline; font-family: 仿宋_GB2312;&quot;&gt;               &lt;/span&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;&quot;&gt;工作（可填写工作单位、工作性质等）。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;七、本《承诺书》未尽事宜按国家有关法律法规和公司规定执行。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;违反上述承诺，本人自愿承担党纪、政纪责任和法律后果。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 16px;&quot;&gt;八、本《承诺书》经双方签字后生效。一式三份，公司保密管理部门、组织人事部门和承诺人各一份。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:28px;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt;xxxx有限公司保密委员会   &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt;承 诺 人（签字）：签名占位符1                            &lt;/span&gt;&lt;span style=&quot;font-family: 宋体, SimSun; font-size: 18px; text-align: right; text-indent: 43px;&quot;&gt;  部门负责人（签字）：签名占位符2&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;text-autospace:none;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;text-autospace:none;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt;   年  月  日                                                      年  月  日&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;text-autospace:none;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 18px; font-family: 宋体, SimSun;&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;text-autospace:none;vertical-align:baseline;line-height:37px&quot;&gt;&lt;span style=&quot;font-size: 16px; font-family: 宋体, SimSun;&quot;&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;备注：&lt;/span&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;&lt;span style=&quot;font-size: 16px;&quot;&gt;脱密期限由本单位根据涉密人员接触、知悉国家秘密和企业秘密的密级、数量、时间等情况确定。一般情况下，核心涉密人员为&lt;/span&gt;2年至3年，重要涉密人员为1年至2年，一般涉密人员为6个月至1年（法律法规或国家有关主管部门有特殊规定的按规定办理）。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', NULL, '{\"files\":[{\"url\":\"protocol\\/20181031\\/6353975be9bae725a55135181ee438d5.doc\",\"name\":\"xxxx保密工作责任书（通用部门）.doc\"}]}', 4, 0),
(2, 0, 1, 1, 1, 1, 1, 0, 0, 2, 0, 0, 0, 1541436042, 1542457118, 1540823400, 1542644841, 'XXXX公司涉密人员保证书', '', '', '', '', '\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p&gt;&lt;span style=&quot;;font-family:方正小标宋_GBK;font-size:29px&quot;&gt; &lt;/span&gt;&lt;span style=&quot;font-family: 方正小标宋_GBK; font-size: 48px; text-align: center;&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;;font-family:方正小标宋_GBK;font-size:48px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:方正小标宋_GBK;font-size:48px&quot;&gt;&lt;span style=&quot;font-family:方正小标宋_GBK&quot;&gt;有限公司&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;;font-family:方正小标宋_GBK;font-size:48px&quot;&gt;&lt;span style=&quot;font-family:方正小标宋_GBK&quot;&gt;保密工作责任书&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（&lt;/span&gt;201&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;8&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;年度）&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;       &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;部门：&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;text-decoration:underline;&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;            &lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent: 188px; text-align: center;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;201&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;7&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;年&lt;/span&gt;12月&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体;font-size: 24px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;为认真贯彻落实《中华人民共和国保守国家秘密法》《国家电网公司保密工作管理办法》和相关保密法律法规，确保国家秘密和企业秘密的安全，维护国家利益和公司利益，特签订本责任书。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:黑体;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:黑体&quot;&gt;一、责任目标&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;根据&lt;/span&gt;“积极防范、突出重点、依法管理，既确保国家秘密和企业秘密安全，又便利信息资源合理利用”的保密工作方针，切实履行保密工作的领导职责，确保本部门在责任期内不发生失泄密事件，具体做到：&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（一）实行保密工作责任制。切实加强本部门对保密工作的领导，落实保密工作责任制，坚持保密工作与业务工作同部署、同检查、同落实，保证本部门各项保密工作措施落实到位，确保不发生失泄密事件。主要领导是保密工作第一责任人，对保密工作负总责；分管领导负责具体保密组织工作；其他领导负责分管范围内的保密工作。明确承担日常保密管理工作的人员及其职责。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（二）严格执行各项保密制度。认真执行国家有关保密工作法规标准、国家电网有限公司及&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司有关制度的要求，把定密工作、保密宣传教育、涉密人员管理、计算机网络保密管理、涉密载体管理等纳入规范化、制度化轨道。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（三）加强部门人员的管理。部门员工（含挂职挂岗、借调人员）必须签订《员工保密承诺书》，涉密人员必须签订《涉密人员保证书》，涉密人员离岗时必须签订《涉密人员离岗保密承诺书》，并做好在岗、离岗人员协议履行的动态管理。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（四）依照保密法规，认真做好本部门各项业务所产生的涉密事项的密级确定及变更管理，严格执行定密责任人制度，定密责任人具体负责定密、解密工作，做到定密准确，不高定、乱定或有密不定、非密定密、及时解密。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（五）加强对合作单位及其人员的保密监督。对有机会接触涉密事项的合作单位及其人员，要强化保密教育和监管工作，将安全保密方面的要求作为合作的前置条件，严格签署安全保密协议，认真落实其担负的保密责任和义务。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（六）完善保密防护措施。加强计算机网络管理和涉密载体管理，&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;对涉密计算机、涉密载体实行统一管理、定期检查。加强接入公司信息内&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;、&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;外网计算机的准入管理和安全防护，严禁内&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;、&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;外网计算机及其&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;外部设备&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;混用（既连接信息内网，又连接信息外网），加强远程维护的监管，采取有效措施防范病毒、木马。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（七）严格信息发布审核审批制度。对本部门内网、外网信息发布进行严格审查。切实加强对微博、微信等信息发布的管理。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（八）认真开展保密宣传教育培训工作。将保密教育培训列入本部门年度培训计划中。抓好领导干部、涉密人员和保密干部等重点人员的教育培训。组织开展员工教育培训，确保员工知悉岗位业务中涉及国家秘密、企业秘密的具体事项，掌握基本保密知识和技能，自觉履行保密义务。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（九）强化保密监督检查。定期或不定期组织本部门开展全面系统的保密检查，通报检查结果。严肃查处泄密事件，查处保密工作中的失职、渎职行为，查处各种违规行为，依法追究有关责任人员的责任；堵塞泄密漏洞，消除隐患。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（十）认真执行公司重大事项上报制度。发现本部门泄密事件时，立即采取补救措施，同时将有关情况如实向&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司保密委员会办公室报告，决不隐瞒。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:黑体;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:黑体&quot;&gt;二、检查考核&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;根据国家和公司有关保密规定，&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司保密委员会定期组织保密检查，通报检查结果。对保密工作中的违规现象，要严肃追究责任。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:黑体;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:黑体&quot;&gt;三、涉密事项&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（一）国家秘密&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;本部门涉及国家秘密&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;的事项，应严格按照有关保密规定管理，国家秘密的知悉范围应当根据工作需要限定在最小范围。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;（二）企业秘密&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;本部门涉及企业秘密&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;的事项，应严格按照&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司涉密事项目录范围管理，企业秘密的知悉范围应当根据工作需要限定在最小范围。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:黑体;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:黑体&quot;&gt;四、附则&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;本《保密工作责任书》未尽事宜按国家有关法律法规和公司规定执行。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;本责任书一式两份，经双方签字后生效，&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;color:rgb(12,12,12);font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司保密委员会办公室&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;和承诺部门各一份，&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;执行期限自&lt;/span&gt;2018年1月1日至201&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;8&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;年&lt;/span&gt;12月31日。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司保密委员会&lt;/span&gt;     &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;部门：部门签名1                                                      公章占位符1&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:60px;line-height:37px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;(1)年(2)&lt;/span&gt;月(3)日             (4)年(5)月(6)日&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', NULL, NULL, 1, 0),
(3, 0, 1, 1, 1, 1, 1, 0, 0, 25, 0, 0, 0, 1541436400, 1541436400, 1540823400, 1542644841, 'XXXX公司涉密人员保证书', '', '', '', '', '\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;;font-family:方正小标宋_GBK;font-size:29px&quot;&gt; &lt;/span&gt;&lt;span style=&quot;font-family: 方正小标宋_GBK; font-size: 48px;&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;font-family: 方正小标宋_GBK; font-size: 48px;&quot;&gt;有限公司&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;;font-family:方正小标宋_GBK;font-size:48px&quot;&gt;&lt;span style=&quot;font-family:方正小标宋_GBK&quot;&gt;员工保密承诺书&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-family: 方正小标宋_GBK;font-size: 29px&quot;&gt;&lt;span style=&quot;font-family:方正小标宋_GBK&quot;&gt;（&lt;/span&gt;2018年度）&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt; &lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;        &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;部门：&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;text-decoration:underline;&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;            &lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 29px&quot;&gt;2017年12月&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;br style=&quot;page-break-before:always&quot;&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;根据《中华人民共和国保守国家秘密法》以及国家电网有限公司和&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;有限公司保密工作有关规定，作为公司员工，本人对保密责任和义务作以下承诺：&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;一、自觉遵守国家保密法律法规、公司保密规章制度和员工保密守则，严格做到&lt;/span&gt;:&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 21px&quot;&gt;1.涉及国家秘密事项时严格执行“涉密不上网、上网不涉密”的保密规定；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;2.不在公司信息内网、信息外网和互联网上存储、处理、传递国家秘密；不在公司信息外网和互联网上存储、处理、传递企业秘密；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;3.不使用非涉密的计算机、多功能一体机、打印机、扫描仪、传真机和复印机等设备存储、处理、传递国家秘密；不使用与公司信息外网和互联网连接的计算机、打印机、扫描仪、传真机和复印机等设备存储、处理、传递企业秘密；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;4.不将非涉密的计算机、多功能一体机、打印机、扫描仪、传真机和复印机等设备在公司信息内网、信息外网和互联网间交叉连接使用；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;5.不将普通移动存储介质在公司信息内网、信息外网和互联网间交叉使用。在公司信息内网、信息外网上交换文档和数据必须使用公司统一配发的安全移动存储介质；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;6.不在公共场所、私人交往中及家属、子女、亲友面前谈论国家秘密和企业秘密；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;7.不在私人通信及公开发表的文章、著述中涉及国家秘密和企业秘密；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;8.不使用无保密保障的普通传真机、电话机和手机等通信工具传输或谈论国家秘密和企业秘密；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;9.不在无保密保障的场所阅办或保存涉密文件、资料，不私自留存阅办完毕的涉密文件、资料；不擅自销毁涉密文件、资料；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;10.严格执行涉密文件、资料的各项管理规定，不擅自复印、扫描、传真涉密文件或扩大涉密文件的知悉范围；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;11.未经单位审查批准，不擅自发表涉及未公开工作内容的文章、著述；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;12.未经单位批准，不擅自将公司的各种文件、资料及企业秘密泄露给第三方；&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;13.未经批准，不在外事、社会活动中携带涉密文件、资料。因公或因私出国（境）时，严格遵守保密法纪和公司规定。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;14.不在个人博客、微博、微信、各类论坛上发布涉及国家秘密和企业秘密的信息和事项；不发布公司内部事项、重要数据和与企业经营、管理、业务、技术有关的工作信息。个人微博、微信等内容只限于个人生活内容，且只表达和代表个人观点，并对自己所发布的信息承担相应的法律责任。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;二、对本岗位工作中涉及的密件、密电在收发、登记、分办、送批、传阅、保存、归档的各个环节都严格遵守公司的各项保密制度，不擅自扩大知悉范围，确保国家秘密和企业秘密的安全。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;三、认真执行公司和部门重大事项上报制度。本人发生失泄密事件时，立即采取补救措施，同时将有关情况向部门领导汇报，决不隐瞒。发现他人违反保密规定、泄露国家和企业秘密时，立即予以制止，并及时向公司保密委员会办公室报告。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;四、自觉学习保密知识，提高保密意识，掌握保密技能，接受保密教育和保密监督、检查，及时消除保密隐患，堵塞管理漏洞。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;五&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;letter-spacing:-1px;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;、若有违反上述承诺行为，将承担相应责任直至法律后果。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;六、本《承诺书》未尽事宜按国家有关法律法规和公司规定执行。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;七、本《承诺书》一式两份，经双方签字后生效，承诺人所在部门和承诺人各一份，执行期限自&lt;/span&gt;2018年1月1日至2018年12月31日。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:53px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;  &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;负&lt;/span&gt; &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;责&lt;/span&gt; &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;人&lt;/span&gt;                        &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;承&lt;/span&gt; &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;诺&lt;/span&gt; &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;人&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt; &lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:28px;line-height:35px&quot;&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 21px&quot;&gt;    &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;年&lt;/span&gt;  &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;月&lt;/span&gt;  &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;日&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;;font-family:仿宋_GB2312;font-size:21px&quot;&gt;                      &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;年&lt;/span&gt;  &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;月&lt;/span&gt;  &lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;日&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;line-height:35px&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 仿宋_GB2312;font-size: 21px&quot;&gt;&lt;span style=&quot;font-family:仿宋_GB2312&quot;&gt;备注：&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;1.国家秘密是关系国家的安全和利益，依照法定程序确定，在一定时间内只限一定范围的人员知悉的事项。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;2.&lt;/span&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;xxxx&lt;/span&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:方正仿宋_GBK&quot;&gt;有限公司企业秘密包括商业秘密和工作秘密。公司商业秘密是指为公司所有、且不为公众所知悉、能为公司带来经济利益、具有实用性并经公司采取保密措施的经营信息和技术信息。按重要程度以及泄露后会使公司的经济利益遭受损害的程度，确定为核心商业秘密、普通商业秘密两级，密级标注为&lt;/span&gt;“核心商密”、“普通商密”。&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;&lt;span style=&quot;font-family:方正仿宋_GBK&quot;&gt;工作秘密是指公司商业秘密之外的，泄露后会给公司工作造成被动或损害的内部事项。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;3.公司&lt;/span&gt;&lt;span style=&quot;font-family: 方正仿宋_GBK;font-size: 21px&quot;&gt;&lt;span style=&quot;font-family:方正仿宋_GBK&quot;&gt;信息内网定位为公司工作业务应用承载网络和内部办公网络。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p style=&quot;text-indent:43px;line-height:35px&quot;&gt;&lt;span style=&quot;;font-family:方正仿宋_GBK;font-size:21px&quot;&gt;4.公司&lt;/span&gt;&lt;span style=&quot;font-family: 方正仿宋_GBK;font-size: 21px&quot;&gt;&lt;span style=&quot;font-family:方正仿宋_GBK&quot;&gt;信息外网定位为对外业务应用网络和访问互联网用户终端网络。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n&lt;p&gt;&lt;br&gt;&lt;/p&gt;\n', NULL, NULL, 0, 0),
(4, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542459542, 1542459542, 1542459542, 1542459886, 'test', '', '', '', '', NULL, NULL, NULL, 0, 0),
(5, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542459624, 1542459624, 1542459624, 1542459882, 'test', '', '', '', '', NULL, NULL, NULL, 0, 0),
(6, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542459809, 1542459809, 1542459809, 1542459878, 'test', '', '', '', '', NULL, NULL, NULL, 0, 0),
(7, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542459830, 1542459830, 1542459830, 1542459874, 'test', '', '', '', '', NULL, NULL, NULL, 0, 0),
(8, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542459899, 1542459899, 1542459899, 1542644841, 'test', '', '', '', '', NULL, NULL, NULL, 0, 0),
(9, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542644902, 1542644902, 1542644902, 1542644987, '国网浙江省电力有限公司  员工保密承诺书', '', '', '', '', NULL, NULL, NULL, 0, 0),
(10, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1542644920, 1542644920, 1542644920, 1542644984, 'test', '', '', '', '', NULL, NULL, NULL, 1, 0),
(27, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1543509322, 1543658256, 1543509322, 0, 'test', '', '', '', '', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `so_recycle_bin`
--

CREATE TABLE `so_recycle_bin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `object_id` int(11) DEFAULT '0' COMMENT '删除内容 id',
  `create_time` int(10) UNSIGNED DEFAULT '0' COMMENT '创建时间',
  `table_name` varchar(60) DEFAULT '' COMMENT '删除内容所在表名',
  `name` varchar(255) DEFAULT '' COMMENT '删除内容名称',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=' 回收站';

--
-- 转存表中的数据 `so_recycle_bin`
--

INSERT INTO `so_recycle_bin` (`id`, `object_id`, `create_time`, `table_name`, `name`, `user_id`) VALUES
(1, 6, 1540719949, 'frame_category', 'test7', 0),
(2, 5, 1540719955, 'frame_category', 'test6', 0),
(3, 2, 1540720480, 'vague_category', 'test2', 0),
(4, 4, 1540720516, 'frame_category', 'test5', 0),
(5, 2, 1540720523, 'frame_category', 'test24', 0),
(6, 1, 1540720526, 'frame_category', 'test1', 0),
(7, 2, 1540720976, 'identity_category', 'test2', 0),
(8, 2, 1540736262, 'role_category', 'test2', 0),
(9, 2, 1540737051, 'seal_category', 'test2', 0),
(10, 2, 1540915549, 'protocol_category', 'test2', 0),
(11, 11, 1542987193, 'protocol_category', 'test', 0),
(12, 12, 1543149982, 'protocol_category', 'test', 0),
(13, 13, 1543509014, 'protocol_category', 'test', 0);

-- --------------------------------------------------------

--
-- 表的结构 `so_role`
--

CREATE TABLE `so_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父角色ID',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态;0:禁用;1:正常',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `list_order` float NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

--
-- 转存表中的数据 `so_role`
--

INSERT INTO `so_role` (`id`, `parent_id`, `status`, `create_time`, `update_time`, `list_order`, `name`, `remark`) VALUES
(1, 0, 1, 1329633709, 1329633709, 0, '超级管理员', '拥有网站最高管理员权限！'),
(2, 0, 1, 1329633709, 1329633709, 0, '普通管理员', '权限由最高管理员分配！');

-- --------------------------------------------------------

--
-- 表的结构 `so_role_category`
--

CREATE TABLE `so_role_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_role_category`
--

INSERT INTO `so_role_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`) VALUES
(1, 0, 0, 1, 0, 10000, '涉密人员', '', '0-1', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(2, 1, 0, 0, 1540736262, 10000, 'test2', '', '0-1-2', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(3, 0, 0, 1, 0, 10000, '非涉密人员', '', '0-3', '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_role_category_post`
--

CREATE TABLE `so_role_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_role_category_post`
--

INSERT INTO `so_role_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(1, 5, 0, 10000, 1),
(2, 5, 1, 10000, 1),
(3, 3, 0, 10000, 1),
(4, 9, 3, 10000, 1),
(5, 10, 3, 10000, 1),
(6, 11, 0, 10000, 1),
(7, 11, 0, 10000, 1),
(8, 11, 0, 10000, 1),
(9, 11, 0, 10000, 1),
(10, 12, 0, 10000, 1),
(11, 13, 0, 10000, 1),
(12, 13, 0, 10000, 1),
(13, 13, 0, 10000, 1),
(14, 14, 0, 10000, 1),
(15, 11, 0, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_role_user`
--

CREATE TABLE `so_role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '角色 id',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- --------------------------------------------------------

--
-- 表的结构 `so_route`
--

CREATE TABLE `so_route` (
  `id` int(11) NOT NULL COMMENT '路由id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态;1:启用,0:不启用',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'URL规则类型;1:用户自定义;2:别名添加',
  `full_url` varchar(255) NOT NULL DEFAULT '' COMMENT '完整url',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '实际显示的url'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='url路由表';

-- --------------------------------------------------------

--
-- 表的结构 `so_seal_category`
--

CREATE TABLE `so_seal_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_seal_category`
--

INSERT INTO `so_seal_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`) VALUES
(1, 0, 0, 1, 0, 10000, '公司公章1', '', '0-1', '', '', '', 'list', 'article', '{\"thumbnail\":\"seal\\/20181114\\/0abacc1c1600da3bca515003160af283.jpeg\"}'),
(2, 1, 0, 1, 1540737051, 10000, 'test2', '', '0-1-2', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(3, 0, 0, 1, 0, 10000, '公司公章2', '', '0-3', '', '', '', '', '', '{\"thumbnail\":\"seal\\/20181120\\/4ec1cf744573a9ca9c25db200f5379f5.jpeg\"}'),
(4, 0, 0, 1, 0, 10000, '行政公章3', '', '0-4', '', '', '', '', '', '{\"thumbnail\":\"\"}');

-- --------------------------------------------------------

--
-- 表的结构 `so_seal_category_post`
--

CREATE TABLE `so_seal_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

-- --------------------------------------------------------

--
-- 表的结构 `so_slide`
--

CREATE TABLE `so_slide` (
  `id` int(11) NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:显示,0不显示',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `name` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片分类',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分类备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='幻灯片表';

-- --------------------------------------------------------

--
-- 表的结构 `so_slide_item`
--

CREATE TABLE `so_slide_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `slide_id` int(11) NOT NULL DEFAULT '0' COMMENT '幻灯片id',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:显示;0:隐藏',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '幻灯片名称',
  `image` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片图片',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '幻灯片链接',
  `target` varchar(10) NOT NULL DEFAULT '' COMMENT '友情链接打开方式',
  `description` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '幻灯片描述',
  `content` text CHARACTER SET utf8 COMMENT '幻灯片内容',
  `more` text COMMENT '扩展信息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='幻灯片子项表';

-- --------------------------------------------------------

--
-- 表的结构 `so_theme`
--

CREATE TABLE `so_theme` (
  `id` int(11) NOT NULL,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后升级时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '模板状态,1:正在使用;0:未使用',
  `is_compiled` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否为已编译模板',
  `theme` varchar(20) NOT NULL DEFAULT '' COMMENT '主题目录名，用于主题的维一标识',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '主题名称',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '主题版本号',
  `demo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '演示地址，带协议',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `author` varchar(20) NOT NULL DEFAULT '' COMMENT '主题作者',
  `author_url` varchar(50) NOT NULL DEFAULT '' COMMENT '作者网站链接',
  `lang` varchar(10) NOT NULL DEFAULT '' COMMENT '支持语言',
  `keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '主题关键字',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '主题描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `so_theme`
--

INSERT INTO `so_theme` (`id`, `create_time`, `update_time`, `status`, `is_compiled`, `theme`, `name`, `version`, `demo_url`, `thumbnail`, `author`, `author_url`, `lang`, `keywords`, `description`) VALUES
(1, 0, 0, 0, 0, 'simpleboot3', 'simpleboot3', '1.0.2', 'http://demo.thinkcmf.com', '', 'ThinkCMF', 'http://www.thinkcmf.com', 'zh-cn', 'ThinkCMF模板', 'ThinkCMF默认模板');

-- --------------------------------------------------------

--
-- 表的结构 `so_theme_file`
--

CREATE TABLE `so_theme_file` (
  `id` int(11) NOT NULL,
  `is_public` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否公共的模板文件',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `theme` varchar(20) NOT NULL DEFAULT '' COMMENT '模板名称',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '模板文件名',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作',
  `file` varchar(50) NOT NULL DEFAULT '' COMMENT '模板文件，相对于模板根目录，如Portal/index.html',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '模板文件描述',
  `more` text COMMENT '模板更多配置,用户自己后台设置的',
  `config_more` text COMMENT '模板更多配置,来源模板的配置文件',
  `draft_more` text COMMENT '模板更多配置,用户临时保存的配置'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `so_theme_file`
--

INSERT INTO `so_theme_file` (`id`, `is_public`, `list_order`, `theme`, `name`, `action`, `file`, `description`, `more`, `config_more`, `draft_more`) VALUES
(1, 0, 10, 'simpleboot3', '文章页', 'portal/Article/index', 'portal/article', '文章页模板文件', '{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '{\"vars\":{\"hot_articles_category_id\":{\"title\":\"Hot Articles\\u5206\\u7c7bID\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', NULL),
(2, 0, 10, 'simpleboot3', '联系我们页', 'portal/Page/index', 'portal/contact', '联系我们页模板文件', '{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"ThinkCMF<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def2601\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 Xie Tu Road, Shanghai China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}', '{\"vars\":{\"baidu_map_info_window_text\":{\"title\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57\",\"name\":\"baidu_map_info_window_text\",\"value\":\"ThinkCMF<br\\/><span class=\'\'>\\u5730\\u5740\\uff1a\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def2601\\u53f7<\\/span>\",\"type\":\"text\",\"tip\":\"\\u767e\\u5ea6\\u5730\\u56fe\\u6807\\u6ce8\\u6587\\u5b57,\\u652f\\u6301\\u7b80\\u5355html\\u4ee3\\u7801\",\"rule\":[]},\"company_location\":{\"title\":\"\\u516c\\u53f8\\u5750\\u6807\",\"value\":\"\",\"type\":\"location\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_cn\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\",\"value\":\"\\u4e0a\\u6d77\\u5e02\\u5f90\\u6c47\\u533a\\u659c\\u571f\\u8def0001\\u53f7\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"address_en\":{\"title\":\"\\u516c\\u53f8\\u5730\\u5740\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"NO.0001 Xie Tu Road, Shanghai China\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"email\":{\"title\":\"\\u516c\\u53f8\\u90ae\\u7bb1\",\"value\":\"catman@thinkcmf.com\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_cn\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\",\"value\":\"021 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"phone_en\":{\"title\":\"\\u516c\\u53f8\\u7535\\u8bdd\\uff08\\u82f1\\u6587\\uff09\",\"value\":\"+8621 1000 0001\",\"type\":\"text\",\"tip\":\"\",\"rule\":{\"require\":true}},\"qq\":{\"title\":\"\\u8054\\u7cfbQQ\",\"value\":\"478519726\",\"type\":\"text\",\"tip\":\"\\u591a\\u4e2a QQ\\u4ee5\\u82f1\\u6587\\u9017\\u53f7\\u9694\\u5f00\",\"rule\":{\"require\":true}}}}', NULL),
(3, 0, 5, 'simpleboot3', '首页', 'portal/Index/index', 'portal/index', '首页模板文件', '{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/Category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"vars\":{\"top_slide\":{\"title\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"admin\\/Slide\\/index\",\"multi\":false},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"tip\":\"\\u9876\\u90e8\\u5e7b\\u706f\\u7247\",\"rule\":{\"require\":true}}},\"widgets\":{\"features\":{\"title\":\"\\u5feb\\u901f\\u4e86\\u89e3ThinkCMF\",\"display\":\"1\",\"vars\":{\"sub_title\":{\"title\":\"\\u526f\\u6807\\u9898\",\"value\":\"Quickly understand the ThinkCMF\",\"type\":\"text\",\"placeholder\":\"\\u8bf7\\u8f93\\u5165\\u526f\\u6807\\u9898\",\"tip\":\"\",\"rule\":{\"require\":true}},\"features\":{\"title\":\"\\u7279\\u6027\\u4ecb\\u7ecd\",\"value\":[{\"title\":\"MVC\\u5206\\u5c42\\u6a21\\u5f0f\",\"icon\":\"bars\",\"content\":\"\\u4f7f\\u7528MVC\\u5e94\\u7528\\u7a0b\\u5e8f\\u88ab\\u5206\\u6210\\u4e09\\u4e2a\\u6838\\u5fc3\\u90e8\\u4ef6\\uff1a\\u6a21\\u578b\\uff08M\\uff09\\u3001\\u89c6\\u56fe\\uff08V\\uff09\\u3001\\u63a7\\u5236\\u5668\\uff08C\\uff09\\uff0c\\u4ed6\\u4e0d\\u662f\\u4e00\\u4e2a\\u65b0\\u7684\\u6982\\u5ff5\\uff0c\\u53ea\\u662fThinkCMF\\u5c06\\u5176\\u53d1\\u6325\\u5230\\u4e86\\u6781\\u81f4\\u3002\"},{\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"group\",\"content\":\"ThinkCMF\\u5185\\u7f6e\\u4e86\\u7075\\u6d3b\\u7684\\u7528\\u6237\\u7ba1\\u7406\\u65b9\\u5f0f\\uff0c\\u5e76\\u53ef\\u76f4\\u63a5\\u4e0e\\u7b2c\\u4e09\\u65b9\\u7ad9\\u70b9\\u8fdb\\u884c\\u4e92\\u8054\\u4e92\\u901a\\uff0c\\u5982\\u679c\\u4f60\\u613f\\u610f\\u751a\\u81f3\\u53ef\\u4ee5\\u5bf9\\u5355\\u4e2a\\u7528\\u6237\\u6216\\u7fa4\\u4f53\\u7528\\u6237\\u7684\\u884c\\u4e3a\\u8fdb\\u884c\\u8bb0\\u5f55\\u53ca\\u5206\\u4eab\\uff0c\\u4e3a\\u60a8\\u7684\\u8fd0\\u8425\\u51b3\\u7b56\\u63d0\\u4f9b\\u6709\\u6548\\u53c2\\u8003\\u6570\\u636e\\u3002\"},{\"title\":\"\\u4e91\\u7aef\\u90e8\\u7f72\",\"icon\":\"cloud\",\"content\":\"\\u901a\\u8fc7\\u9a71\\u52a8\\u7684\\u65b9\\u5f0f\\u53ef\\u4ee5\\u8f7b\\u677e\\u652f\\u6301\\u4e91\\u5e73\\u53f0\\u7684\\u90e8\\u7f72\\uff0c\\u8ba9\\u4f60\\u7684\\u7f51\\u7ad9\\u65e0\\u7f1d\\u8fc1\\u79fb\\uff0c\\u5185\\u7f6e\\u5df2\\u7ecf\\u652f\\u6301SAE\\u3001BAE\\uff0c\\u6b63\\u5f0f\\u7248\\u5c06\\u5bf9\\u4e91\\u7aef\\u90e8\\u7f72\\u8fdb\\u884c\\u8fdb\\u4e00\\u6b65\\u4f18\\u5316\\u3002\"},{\"title\":\"\\u5b89\\u5168\\u7b56\\u7565\",\"icon\":\"heart\",\"content\":\"\\u63d0\\u4f9b\\u7684\\u7a33\\u5065\\u7684\\u5b89\\u5168\\u7b56\\u7565\\uff0c\\u5305\\u62ec\\u5907\\u4efd\\u6062\\u590d\\uff0c\\u5bb9\\u9519\\uff0c\\u9632\\u6cbb\\u6076\\u610f\\u653b\\u51fb\\u767b\\u9646\\uff0c\\u7f51\\u9875\\u9632\\u7be1\\u6539\\u7b49\\u591a\\u9879\\u5b89\\u5168\\u7ba1\\u7406\\u529f\\u80fd\\uff0c\\u4fdd\\u8bc1\\u7cfb\\u7edf\\u5b89\\u5168\\uff0c\\u53ef\\u9760\\uff0c\\u7a33\\u5b9a\\u7684\\u8fd0\\u884c\\u3002\"},{\"title\":\"\\u5e94\\u7528\\u6a21\\u5757\\u5316\",\"icon\":\"cubes\",\"content\":\"\\u63d0\\u51fa\\u5168\\u65b0\\u7684\\u5e94\\u7528\\u6a21\\u5f0f\\u8fdb\\u884c\\u6269\\u5c55\\uff0c\\u4e0d\\u7ba1\\u662f\\u4f60\\u5f00\\u53d1\\u4e00\\u4e2a\\u5c0f\\u529f\\u80fd\\u8fd8\\u662f\\u4e00\\u4e2a\\u5168\\u65b0\\u7684\\u7ad9\\u70b9\\uff0c\\u5728ThinkCMF\\u4e2d\\u4f60\\u53ea\\u662f\\u589e\\u52a0\\u4e86\\u4e00\\u4e2aAPP\\uff0c\\u6bcf\\u4e2a\\u72ec\\u7acb\\u8fd0\\u884c\\u4e92\\u4e0d\\u5f71\\u54cd\\uff0c\\u4fbf\\u4e8e\\u7075\\u6d3b\\u6269\\u5c55\\u548c\\u4e8c\\u6b21\\u5f00\\u53d1\\u3002\"},{\"title\":\"\\u514d\\u8d39\\u5f00\\u6e90\",\"icon\":\"certificate\",\"content\":\"\\u4ee3\\u7801\\u9075\\u5faaApache2\\u5f00\\u6e90\\u534f\\u8bae\\uff0c\\u514d\\u8d39\\u4f7f\\u7528\\uff0c\\u5bf9\\u5546\\u4e1a\\u7528\\u6237\\u4e5f\\u65e0\\u4efb\\u4f55\\u9650\\u5236\\u3002\"}],\"type\":\"array\",\"item\":{\"title\":{\"title\":\"\\u6807\\u9898\",\"value\":\"\",\"type\":\"text\",\"rule\":{\"require\":true}},\"icon\":{\"title\":\"\\u56fe\\u6807\",\"value\":\"\",\"type\":\"text\"},\"content\":{\"title\":\"\\u63cf\\u8ff0\",\"value\":\"\",\"type\":\"textarea\"}},\"tip\":\"\"}}},\"last_news\":{\"title\":\"\\u6700\\u65b0\\u8d44\\u8baf\",\"display\":\"1\",\"vars\":{\"last_news_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/Category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', NULL),
(4, 0, 10, 'simpleboot3', '文章列表页', 'portal/List/index', 'portal/list', '文章列表模板文件', '{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"vars\":[],\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', NULL),
(5, 0, 10, 'simpleboot3', '单页面', 'portal/Page/index', 'portal/page', '单页面模板文件', '{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', '{\"widgets\":{\"hottest_articles\":{\"title\":\"\\u70ed\\u95e8\\u6587\\u7ae0\",\"display\":\"1\",\"vars\":{\"hottest_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}},\"last_articles\":{\"title\":\"\\u6700\\u65b0\\u53d1\\u5e03\",\"display\":\"1\",\"vars\":{\"last_articles_category_id\":{\"title\":\"\\u6587\\u7ae0\\u5206\\u7c7bID\",\"value\":\"\",\"type\":\"text\",\"dataSource\":{\"api\":\"portal\\/category\\/index\",\"multi\":true},\"placeholder\":\"\\u8bf7\\u9009\\u62e9\\u5206\\u7c7b\",\"tip\":\"\",\"rule\":{\"require\":true}}}}}}', NULL),
(6, 0, 10, 'simpleboot3', '搜索页面', 'portal/search/index', 'portal/search', '搜索模板文件', '{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}', '{\"vars\":{\"varName1\":{\"title\":\"\\u70ed\\u95e8\\u641c\\u7d22\",\"value\":\"1\",\"type\":\"text\",\"tip\":\"\\u8fd9\\u662f\\u4e00\\u4e2atext\",\"rule\":{\"require\":true}}}}', NULL),
(7, 1, 0, 'simpleboot3', '模板全局配置', 'public/Config', 'public/config', '模板全局配置文件', '{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}', '{\"vars\":{\"enable_mobile\":{\"title\":\"\\u624b\\u673a\\u6ce8\\u518c\",\"value\":1,\"type\":\"select\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"},\"tip\":\"\"}}}', NULL),
(8, 1, 1, 'simpleboot3', '导航条', 'public/Nav', 'public/nav', '导航条模板文件', '{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"ThinkCMF\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', '{\"vars\":{\"company_name\":{\"title\":\"\\u516c\\u53f8\\u540d\\u79f0\",\"name\":\"company_name\",\"value\":\"ThinkCMF\",\"type\":\"text\",\"tip\":\"\",\"rule\":[]}}}', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_third_party_user`
--

CREATE TABLE `so_third_party_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '本站用户id',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `expire_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'access_token过期时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `login_times` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态;1:正常;0:禁用',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `third_party` varchar(20) NOT NULL DEFAULT '' COMMENT '第三方惟一码',
  `app_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方应用 id',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `access_token` varchar(512) NOT NULL DEFAULT '' COMMENT '第三方授权码',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '第三方用户id',
  `union_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方用户多个产品中的惟一 id,(如:微信平台)',
  `more` text COMMENT '扩展信息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='第三方用户表';

-- --------------------------------------------------------

--
-- 表的结构 `so_user`
--

CREATE TABLE `so_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '用户类型;1:admin;2:会员',
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别;0:保密,1:男,2:女',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `coin` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '金币',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '用户状态;0:禁用,1:正常,2:未验证',
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码;cmf_password加密',
  `user_nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '用户登录邮箱',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网址',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `signature` varchar(255) NOT NULL DEFAULT '' COMMENT '个性签名',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '中国手机不带国家代码，国际手机号格式为：国家代码-手机号',
  `more` text COMMENT '扩展属性',
  `department` int(11) NOT NULL DEFAULT '0' COMMENT '部门/单位',
  `vague` int(11) NOT NULL DEFAULT '0' COMMENT '模糊岗位',
  `identity` int(11) NOT NULL DEFAULT '0' COMMENT '员工身份',
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '员工角色',
  `user_content` text COMMENT '岗位调动详情'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

--
-- 转存表中的数据 `so_user`
--

INSERT INTO `so_user` (`id`, `user_type`, `sex`, `birthday`, `last_login_time`, `score`, `coin`, `balance`, `create_time`, `user_status`, `user_login`, `user_pass`, `user_nickname`, `user_email`, `user_url`, `avatar`, `signature`, `last_login_ip`, `user_activation_key`, `mobile`, `more`, `department`, `vague`, `identity`, `role`, `user_content`) VALUES
(1, 1, 0, 0, 1543650173, 0, 0, '0.00', 1540706924, 1, 'admin', '###278971b3bc08b5c9d9547eee4c277a04', 'admin', 'admin@admin.com', '', '', '', '127.0.0.1', '', '', NULL, 0, 0, 0, 0, ''),
(2, 2, 0, 0, 1540710550, 0, 0, '0.00', 1540710550, 1, 'test5', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041226', NULL, 0, 0, 0, 0, ''),
(3, 2, 0, 0, 1540740245, 0, 0, '0.00', 1540740245, 1, 'test2', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13712345678', NULL, 0, 0, 0, 0, ''),
(4, 2, 0, 0, 1540740317, 0, 0, '0.00', 1540740317, 2, 'test3', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041228', NULL, 0, 0, 0, 0, ''),
(5, 2, 0, 0, 1540825676, 0, 0, '0.00', 1540825676, 0, 'test4', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', 'user/20181030/c482121fd4184a20447e335823009980.jpg', '', '127.0.0.1', '', '13726041229', NULL, 0, 0, 0, 0, '&lt;ol class=&quot; list-paddingleft-2&quot; style=&quot;list-style-type: decimal;&quot;&gt;\n&lt;li&gt;&lt;p&gt;晋升经理&lt;/p&gt;&lt;/li&gt;\n&lt;li&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;/li&gt;\n&lt;/ol&gt;'),
(6, 2, 0, 0, 1543240121, 0, 0, '0.00', 1543240121, 1, 'test6', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041230', NULL, 0, 0, 0, 0, NULL),
(7, 2, 0, 0, 1543240795, 0, 0, '0.00', 1543240795, 1, 'test7', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041231', NULL, 0, 0, 0, 0, NULL),
(8, 2, 0, 0, 1543240993, 0, 0, '0.00', 1543240993, 1, 'test8', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041232', NULL, 0, 0, 0, 0, NULL),
(9, 2, 0, 0, 1543241103, 0, 0, '0.00', 1543241103, 1, 'test9', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', 'user/20181126/ddea8b7a34e201e2a4207cf505e78c50.png', '', '127.0.0.1', '', '13726041233', NULL, 0, 0, 0, 0, NULL),
(10, 2, 0, 0, 1543241330, 0, 0, '0.00', 1543241330, 1, 'test10', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041235', NULL, 0, 0, 0, 0, NULL),
(11, 2, 0, 0, 1543241401, 0, 0, '0.00', 1543241401, 1, 'test11', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', 'user/20181126/87e7838f91be33169ba9a4d97fcea259.png', '', '127.0.0.1', '', '13726041237', NULL, 0, 0, 0, 0, NULL),
(12, 2, 0, 0, 1543653230, 0, 0, '0.00', 1543653230, 1, 'test12', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041255', NULL, 0, 0, 0, 0, NULL),
(13, 2, 0, 0, 1543653313, 0, 0, '0.00', 1543653313, 1, 'test14', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041234', NULL, 0, 0, 0, 0, NULL),
(14, 2, 0, 0, 1543655668, 0, 0, '0.00', 1543655668, 1, 'test15', '###53d3872fb6f0ebce0360c982ea13db0b', '', '', '', '', '', '127.0.0.1', '', '13726041236', NULL, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_user_action`
--

CREATE TABLE `so_user_action` (
  `id` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '更改积分，可以为负',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '更改金币，可以为负',
  `reward_number` int(11) NOT NULL DEFAULT '0' COMMENT '奖励次数',
  `cycle_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '周期类型;0:不限;1:按天;2:按小时;3:永久',
  `cycle_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '周期时间值',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户操作名称',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '用户操作名称',
  `app` varchar(50) NOT NULL DEFAULT '' COMMENT '操作所在应用名或插件名等',
  `url` text COMMENT '执行操作的url'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户操作表';

--
-- 转存表中的数据 `so_user_action`
--

INSERT INTO `so_user_action` (`id`, `score`, `coin`, `reward_number`, `cycle_type`, `cycle_time`, `name`, `action`, `app`, `url`) VALUES
(1, 1, 1, 1, 2, 1, '用户登录', 'login', 'user', '');

-- --------------------------------------------------------

--
-- 表的结构 `so_user_action_log`
--

CREATE TABLE `so_user_action_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '访问次数',
  `last_visit_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后访问时间',
  `object` varchar(100) NOT NULL DEFAULT '' COMMENT '访问对象的id,格式:不带前缀的表名+id;如posts1表示xx_posts表里id为1的记录',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作名称;格式:应用名+控制器+操作名,也可自己定义格式只要不发生冲突且惟一;',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户ip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问记录表';

-- --------------------------------------------------------

--
-- 表的结构 `so_user_balance_log`
--

CREATE TABLE `so_user_balance_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户 id',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `change` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '更改余额',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '更改后余额',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户余额变更日志表';

-- --------------------------------------------------------

--
-- 表的结构 `so_user_favorite`
--

CREATE TABLE `so_user_favorite` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户 id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '收藏内容的标题',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `url` varchar(255) DEFAULT NULL COMMENT '收藏内容的原文地址，JSON格式',
  `description` text COMMENT '收藏内容的描述',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '收藏实体以前所在表,不带前缀',
  `object_id` int(10) UNSIGNED DEFAULT '0' COMMENT '收藏内容原来的主键id',
  `create_time` int(10) UNSIGNED DEFAULT '0' COMMENT '收藏时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户收藏表';

-- --------------------------------------------------------

--
-- 表的结构 `so_user_like`
--

CREATE TABLE `so_user_like` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户 id',
  `object_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '内容原来的主键id',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `table_name` varchar(64) NOT NULL DEFAULT '' COMMENT '内容以前所在表,不带前缀',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '内容的原文地址，不带域名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '内容的标题',
  `thumbnail` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `description` text COMMENT '内容的描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户点赞表';

-- --------------------------------------------------------

--
-- 表的结构 `so_user_login_attempt`
--

CREATE TABLE `so_user_login_attempt` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login_attempts` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '尝试次数',
  `attempt_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '尝试登录时间',
  `locked_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '锁定时间',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户 ip',
  `account` varchar(100) NOT NULL DEFAULT '' COMMENT '用户账号,手机号,邮箱或用户名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户登录尝试表' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `so_user_score_log`
--

CREATE TABLE `so_user_score_log` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户 id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '用户操作名称',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '更改积分，可以为负',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '更改金币，可以为负'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户操作积分等奖励日志表';

-- --------------------------------------------------------

--
-- 表的结构 `so_user_token`
--

CREATE TABLE `so_user_token` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `expire_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT ' 过期时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT 'token',
  `device_type` varchar(10) NOT NULL DEFAULT '' COMMENT '设备类型;mobile,android,iphone,ipad,web,pc,mac,wxapp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户客户端登录 token 表';

--
-- 转存表中的数据 `so_user_token`
--

INSERT INTO `so_user_token` (`id`, `user_id`, `expire_time`, `create_time`, `token`, `device_type`) VALUES
(1, 1, 1556258952, 1540706952, 'c2426b0ac0a012b2810447686d7fe481f3de9773bb2a952165f05877b7ad693d', 'web'),
(2, 2, 1556262550, 1540710550, '2ddcdec86fbccf406b5be2dfb6d2a88f34a7868ae1186c824ffaeb1fc7602633', 'web'),
(3, 3, 1556292245, 1540740245, 'efc95b535806437980631ca259504b1cd07f894ff5ea61e380da1e4cc01d15d2', 'web'),
(4, 4, 1556292317, 1540740317, 'bc643a877c421e16ee4fdfab4c1bf2e04b16108f70924f5ab261640cd826a061', 'web'),
(5, 5, 1556377676, 1540825676, '828b7afdc276ea1cc28b549716258ea841795a2d40c9a1e09b95273e4c08daf9', 'web'),
(7, 2, 1557857059, 1542305059, '5d815c7ae62b8bf2ff256363b178c0bad3aa1f0ce4460cad5c17f2b85b691fc8', 'wxapp'),
(8, 3, 1557062669, 1541510669, '724b39b4053c9fa012794af1d18648ac0cfc3fac43fceb21bc0a018b6192980b', 'wxapp'),
(9, 6, 1558792121, 1543240121, 'eda8471e6cf2794d0568bad9f9fbf59f6b17b53d95a553dfa954d9545e28ba6d', 'web'),
(10, 10, 1559061574, 1543509574, 'e037f3bfbea947b623c790e22f888337790d7f09746cfe01058413a872060e30', 'wxapp');

-- --------------------------------------------------------

--
-- 表的结构 `so_vague_category`
--

CREATE TABLE `so_vague_category` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '分类id',
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类父id',
  `post_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类文章数',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布,0:不发布',
  `delete_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '删除时间',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '分类层级关系路径',
  `seo_title` varchar(100) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `list_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类列表模板',
  `one_tpl` varchar(50) NOT NULL DEFAULT '' COMMENT '分类文章页模板',
  `more` text COMMENT '扩展属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='portal应用 文章分类表';

--
-- 转存表中的数据 `so_vague_category`
--

INSERT INTO `so_vague_category` (`id`, `parent_id`, `post_count`, `status`, `delete_time`, `list_order`, `name`, `description`, `path`, `seo_title`, `seo_keywords`, `seo_description`, `list_tpl`, `one_tpl`, `more`) VALUES
(1, 0, 0, 1, 0, 10000, '员工', '', '0-1', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(2, 1, 0, 0, 1540720480, 10000, 'test2', '', '0-1-2', '', '', '', 'list', 'article', '{\"thumbnail\":\"\"}'),
(3, 0, 0, 1, 0, 10000, '部门正职', '', '0-3', '', '', '', '', '', NULL),
(4, 0, 0, 1, 0, 10000, '部门副职', '', '0-4', '', '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `so_vague_category_post`
--

CREATE TABLE `so_vague_category_post` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '文章id',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `list_order` float NOT NULL DEFAULT '10000' COMMENT '排序',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态,1:发布;0:不发布'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='portal应用 分类文章对应表';

--
-- 转存表中的数据 `so_vague_category_post`
--

INSERT INTO `so_vague_category_post` (`id`, `post_id`, `category_id`, `list_order`, `status`) VALUES
(1, 5, 3, 10000, 1),
(2, 3, 0, 10000, 1),
(3, 9, 4, 10000, 1),
(4, 10, 4, 10000, 1),
(5, 11, 0, 10000, 1),
(6, 11, 0, 10000, 1),
(7, 11, 0, 10000, 1),
(8, 11, 0, 10000, 1),
(9, 12, 0, 10000, 1),
(10, 13, 0, 10000, 1),
(11, 13, 0, 10000, 1),
(12, 13, 0, 10000, 1),
(13, 14, 0, 10000, 1),
(14, 11, 0, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `so_verification_code`
--

CREATE TABLE `so_verification_code` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '表id',
  `count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '当天已经发送成功的次数',
  `send_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后发送成功时间',
  `expire_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '验证码过期时间',
  `code` varchar(8) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '最后发送成功的验证码',
  `account` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '手机号或者邮箱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='手机邮箱数字验证码表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `so_admin_menu`
--
ALTER TABLE `so_admin_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `controller` (`controller`);

--
-- Indexes for table `so_asset`
--
ALTER TABLE `so_asset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_auth_access`
--
ALTER TABLE `so_auth_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `rule_name` (`rule_name`) USING BTREE;

--
-- Indexes for table `so_auth_rule`
--
ALTER TABLE `so_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD KEY `module` (`app`,`status`,`type`);

--
-- Indexes for table `so_comment`
--
ALTER TABLE `so_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_id_status` (`table_name`,`object_id`,`status`),
  ADD KEY `object_id` (`object_id`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `parent_id` (`parent_id`) USING BTREE,
  ADD KEY `create_time` (`create_time`) USING BTREE;

--
-- Indexes for table `so_frame_category`
--
ALTER TABLE `so_frame_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_frame_category_post`
--
ALTER TABLE `so_frame_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_frame_category_resp_post`
--
ALTER TABLE `so_frame_category_resp_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_frame_category_secr_post`
--
ALTER TABLE `so_frame_category_secr_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_hook`
--
ALTER TABLE `so_hook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_hook_plugin`
--
ALTER TABLE `so_hook_plugin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_identity_category`
--
ALTER TABLE `so_identity_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_identity_category_post`
--
ALTER TABLE `so_identity_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_link`
--
ALTER TABLE `so_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `so_nav`
--
ALTER TABLE `so_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_nav_menu`
--
ALTER TABLE `so_nav_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_option`
--
ALTER TABLE `so_option`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `so_plugin`
--
ALTER TABLE `so_plugin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_portal_category`
--
ALTER TABLE `so_portal_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_portal_category_post`
--
ALTER TABLE `so_portal_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_portal_post`
--
ALTER TABLE `so_portal_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`create_time`,`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `create_time` (`create_time`) USING BTREE;

--
-- Indexes for table `so_portal_tag`
--
ALTER TABLE `so_portal_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_portal_tag_post`
--
ALTER TABLE `so_portal_tag_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `so_protocol_category`
--
ALTER TABLE `so_protocol_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_protocol_category_post`
--
ALTER TABLE `so_protocol_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_protocol_category_seal_post`
--
ALTER TABLE `so_protocol_category_seal_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_protocol_category_user_post`
--
ALTER TABLE `so_protocol_category_user_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_protocol_post`
--
ALTER TABLE `so_protocol_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`create_time`,`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `create_time` (`create_time`) USING BTREE;

--
-- Indexes for table `so_recycle_bin`
--
ALTER TABLE `so_recycle_bin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_role`
--
ALTER TABLE `so_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `so_role_category`
--
ALTER TABLE `so_role_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_role_category_post`
--
ALTER TABLE `so_role_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_role_user`
--
ALTER TABLE `so_role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `so_route`
--
ALTER TABLE `so_route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_seal_category`
--
ALTER TABLE `so_seal_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_seal_category_post`
--
ALTER TABLE `so_seal_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_slide`
--
ALTER TABLE `so_slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_slide_item`
--
ALTER TABLE `so_slide_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slide_id` (`slide_id`);

--
-- Indexes for table `so_theme`
--
ALTER TABLE `so_theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_theme_file`
--
ALTER TABLE `so_theme_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_third_party_user`
--
ALTER TABLE `so_third_party_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_user`
--
ALTER TABLE `so_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login` (`user_login`),
  ADD KEY `user_nickname` (`user_nickname`);

--
-- Indexes for table `so_user_action`
--
ALTER TABLE `so_user_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_user_action_log`
--
ALTER TABLE `so_user_action_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_object_action` (`user_id`,`object`,`action`),
  ADD KEY `user_object_action_ip` (`user_id`,`object`,`action`,`ip`);

--
-- Indexes for table `so_user_balance_log`
--
ALTER TABLE `so_user_balance_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_user_favorite`
--
ALTER TABLE `so_user_favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`user_id`);

--
-- Indexes for table `so_user_like`
--
ALTER TABLE `so_user_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`user_id`);

--
-- Indexes for table `so_user_login_attempt`
--
ALTER TABLE `so_user_login_attempt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_user_score_log`
--
ALTER TABLE `so_user_score_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_user_token`
--
ALTER TABLE `so_user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_vague_category`
--
ALTER TABLE `so_vague_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `so_vague_category_post`
--
ALTER TABLE `so_vague_category_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `term_taxonomy_id` (`category_id`);

--
-- Indexes for table `so_verification_code`
--
ALTER TABLE `so_verification_code`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `so_admin_menu`
--
ALTER TABLE `so_admin_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;
--
-- 使用表AUTO_INCREMENT `so_asset`
--
ALTER TABLE `so_asset`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `so_auth_access`
--
ALTER TABLE `so_auth_access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_auth_rule`
--
ALTER TABLE `so_auth_rule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键', AUTO_INCREMENT=177;
--
-- 使用表AUTO_INCREMENT `so_comment`
--
ALTER TABLE `so_comment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_frame_category`
--
ALTER TABLE `so_frame_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `so_frame_category_post`
--
ALTER TABLE `so_frame_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `so_frame_category_resp_post`
--
ALTER TABLE `so_frame_category_resp_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `so_frame_category_secr_post`
--
ALTER TABLE `so_frame_category_secr_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `so_hook`
--
ALTER TABLE `so_hook`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- 使用表AUTO_INCREMENT `so_hook_plugin`
--
ALTER TABLE `so_hook_plugin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_identity_category`
--
ALTER TABLE `so_identity_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `so_identity_category_post`
--
ALTER TABLE `so_identity_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `so_link`
--
ALTER TABLE `so_link`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `so_nav`
--
ALTER TABLE `so_nav`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `so_nav_menu`
--
ALTER TABLE `so_nav_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `so_option`
--
ALTER TABLE `so_option`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `so_plugin`
--
ALTER TABLE `so_plugin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `so_portal_category`
--
ALTER TABLE `so_portal_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `so_portal_category_post`
--
ALTER TABLE `so_portal_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `so_portal_post`
--
ALTER TABLE `so_portal_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `so_portal_tag`
--
ALTER TABLE `so_portal_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id';
--
-- 使用表AUTO_INCREMENT `so_portal_tag_post`
--
ALTER TABLE `so_portal_tag_post`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_protocol_category`
--
ALTER TABLE `so_protocol_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `so_protocol_category_post`
--
ALTER TABLE `so_protocol_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- 使用表AUTO_INCREMENT `so_protocol_category_seal_post`
--
ALTER TABLE `so_protocol_category_seal_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- 使用表AUTO_INCREMENT `so_protocol_category_user_post`
--
ALTER TABLE `so_protocol_category_user_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- 使用表AUTO_INCREMENT `so_protocol_post`
--
ALTER TABLE `so_protocol_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- 使用表AUTO_INCREMENT `so_recycle_bin`
--
ALTER TABLE `so_recycle_bin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `so_role`
--
ALTER TABLE `so_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `so_role_category`
--
ALTER TABLE `so_role_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `so_role_category_post`
--
ALTER TABLE `so_role_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `so_role_user`
--
ALTER TABLE `so_role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_route`
--
ALTER TABLE `so_route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '路由id';
--
-- 使用表AUTO_INCREMENT `so_seal_category`
--
ALTER TABLE `so_seal_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `so_seal_category_post`
--
ALTER TABLE `so_seal_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_slide`
--
ALTER TABLE `so_slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_slide_item`
--
ALTER TABLE `so_slide_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_theme`
--
ALTER TABLE `so_theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `so_theme_file`
--
ALTER TABLE `so_theme_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `so_third_party_user`
--
ALTER TABLE `so_third_party_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user`
--
ALTER TABLE `so_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `so_user_action`
--
ALTER TABLE `so_user_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `so_user_action_log`
--
ALTER TABLE `so_user_action_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user_balance_log`
--
ALTER TABLE `so_user_balance_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user_favorite`
--
ALTER TABLE `so_user_favorite`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user_like`
--
ALTER TABLE `so_user_like`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user_login_attempt`
--
ALTER TABLE `so_user_login_attempt`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user_score_log`
--
ALTER TABLE `so_user_score_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `so_user_token`
--
ALTER TABLE `so_user_token`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `so_vague_category`
--
ALTER TABLE `so_vague_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `so_vague_category_post`
--
ALTER TABLE `so_vague_category_post`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `so_verification_code`
--
ALTER TABLE `so_verification_code`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '表id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
