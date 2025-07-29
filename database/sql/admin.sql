
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,'Admin','admin@gmail.com',NULL,'$2y$12$yoilS4pAUeDxo5phW5d4pObOeoiJ0Y6rPaEVxoVQtqCGYb7HEYiGe',NULL,NULL,NULL,NULL,'2025-07-25 02:24:40','2025-07-25 02:24:40');

INSERT INTO `roles` (`id`, `name`, `created_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,'Super Admin',1,NULL,NULL,NULL);


INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,1,1,NULL,NULL,NULL,NULL);

INSERT INTO `menus` (`id`, `idp0`, `idp1`, `idp2`, `idp3`, `name`, `code`, `url`, `route`, `icon`, `priority`, `created_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,0,0,0,0,'Dashboard','A1000','dashboard',NULL,'ri-dashboard-line',1,NULL,NULL,NULL,NULL),
(2,0,0,0,0,'Profile','B1000','profile',NULL,'ri-user-3-line',2,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(3,2,0,0,0,'Request Access to document','B1100','profile/request-access-to-document',NULL,NULL,3,NULL,NULL,'2025-07-25 02:23:51',NULL),
(4,2,3,0,0,'User','B1110','profile/request-access-to-document/user',NULL,NULL,4,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(5,2,3,0,0,'Approver','B1120','profile/request-access-to-document/approver',NULL,NULL,5,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(6,2,0,0,0,'Existing Access','B1200','profile/existing-access',NULL,NULL,6,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(7,2,6,0,0,'List of Documents','B1210','profile/existing-access/list-of-documents',NULL,NULL,7,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(8,0,0,0,0,'Project','C1000','project',NULL,'ri-folder-line',8,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(9,8,0,0,0,'My Project','C1100','project/my-project',NULL,NULL,9,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(10,8,0,0,0,'List of Project','C1200','project/list-of-project',NULL,NULL,10,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(11,0,0,0,0,'Administration','D1000','administration',NULL,'ri-settings-3-line',11,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(12,11,0,0,0,'User Management','D1100','administration/user-management',NULL,NULL,12,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(13,11,12,0,0,'User','D1110','administration/user-management/user',NULL,NULL,13,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(14,11,0,0,0,'Organization Management','D1200','administration/organization-management',NULL,NULL,14,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(15,11,14,0,0,'Company','D1210','administration/organization-management/company',NULL,NULL,15,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(16,11,14,0,0,'Branch','D1220','administration/organization-management/branch',NULL,NULL,16,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(17,11,14,0,0,'Department','D1230','administration/organization-management/department',NULL,NULL,17,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(18,11,14,0,0,'Unit','D1240','administration/organization-management/unit',NULL,NULL,18,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(19,11,14,0,0,'Job Grade','D1250','administration/organization-management/job-grade',NULL,NULL,19,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(20,11,14,0,0,'Designation','D1260','administration/organization-management/department',NULL,NULL,20,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(21,11,0,0,0,'Access Management','D1300','administration/access-management',NULL,NULL,21,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(22,11,21,0,0,'Role','D1310','administration/access-management/role',NULL,NULL,22,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(23,11,21,0,0,'Menu','D1320','administration/access-management/menu',NULL,NULL,23,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(24,11,21,0,0,'Permission','D1330','administration/access-management/permission',NULL,NULL,24,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(25,11,0,0,0,'Audit Management','D1400','administration/audit-management',NULL,NULL,25,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(26,11,25,0,0,'Access Log','D1410','administration/audit-management/access-log',NULL,NULL,26,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51'),
(27,22,25,0,0,'General Log','D1420','administration/audit-management/general-log',NULL,NULL,27,NULL,NULL,'2025-07-25 02:23:51','2025-07-25 02:23:51');

INSERT INTO `permissions` (`id`, `role_id`, `menu_id`, `is_menu`, `read_all`, `read_single`, `add`, `edit`, `delete`, `created_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,1,1,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(2,1,2,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(3,1,3,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(4,1,4,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(5,1,5,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(6,1,6,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(7,1,7,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(8,1,8,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(9,1,9,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(10,1,10,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(11,1,11,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(12,1,12,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(13,1,13,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(14,1,14,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(15,1,15,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(16,1,16,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(17,1,17,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(18,1,18,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(19,1,19,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(20,1,20,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(21,1,21,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(22,1,22,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(23,1,23,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(24,1,24,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(25,1,25,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(26,1,26,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03'),
(27,1,27,1,0,0,0,0,0,1,NULL,'2025-07-25 04:54:03','2025-07-25 04:54:03');
