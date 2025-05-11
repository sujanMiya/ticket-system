CREATE TABLE "public"."users" ( 
  "id" SERIAL,
  "name" VARCHAR(100) NOT NULL,
  "email" VARCHAR(100) NOT NULL,
  "password" VARCHAR(255) NOT NULL,
  "role" VARCHAR(20) NOT NULL DEFAULT 'customer'::character varying ,
  "created_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  "updated_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  CONSTRAINT "users_pkey" PRIMARY KEY ("id"),
  CONSTRAINT "users_email_key" UNIQUE ("email")
);
CREATE INDEX "idx_users_role" 
ON "public"."users" (
  "role" ASC
);

INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (1, 'sujan', 'suja@gmail.com', '8978978970897879', 'admin', '2025-05-03 18:40:02.559776+00', '2025-05-03 18:40:02.559776+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (3, 'Gloria Dunlap', 'wamereq@mailinator.com', '$2y$10$2vSZB0OsZTmpLslrsw5Nw.bS7/3fnQRVgxrnqubuWKJXHe7zYBY6y', 'customer', '2025-05-04 17:43:59+00', '2025-05-04 17:43:59+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (6, 'Amity Pope', 'koteceva@mailinator.com', '$2y$10$GglSMdRjcJo5C86AVO0iGeXerDCLr/mSBfhCH7H2NNdRtkkIX6sgy', 'customer', '2025-05-04 17:57:16+00', '2025-05-04 17:57:16+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (7, 'Reece Wilkinson', 'kydaxu@mailinator.com', '$2y$10$7VcdP46tddZI90GhEtepf.PN3174K80QtHB2Q0SfQaVqvJKs7jTdu', 'customer', '2025-05-04 18:05:50+00', '2025-05-04 18:05:50+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (9, 'Hector Gonzalez', 'tuzehe@mailinator.com', '$2y$10$UM5TUvVxSBMLEEeDOJOm7uCMjxtlukRWxf2x5mcZH2oATreZxkbZu', 'customer', '2025-05-05 01:29:36+00', '2025-05-05 01:29:36+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (11, 'Stone Manning', 'qodutafima@mailinator.com', '$2y$10$xlodJVEmV4lDBKBxnKgo4.uxNDIYwxCAfreSoztMILct3k2t/wita', 'customer', '2025-05-05 15:52:50+00', '2025-05-05 15:52:50+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (12, 'MacKenzie Leach', 'guke@mailinator.com', '$2y$10$acgw/2WpCgIuBtAWBKHMruv2b5MlPaTqL.KLIRAtzIcY5NCZzMldu', 'customer', '2025-05-05 16:09:37+00', '2025-05-05 16:09:37+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (13, 'Aileen Pierce', 'gitiw@mailinator.com', '$2y$10$QE2MOuscOqf3.jGrev7SBeVFuk8Mhc4jgfnQcEWVK/h1Fk1zhJGj.', 'customer', '2025-05-05 16:13:31+00', '2025-05-05 16:13:31+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (14, 'Marvin Richards', 'safu@mailinator.com', '$2y$10$lmCtzavVISfzNBmyseBEzOEv0E4xKao5yMLY72S0vnzUW.VJAtida', 'customer', '2025-05-05 16:17:41+00', '2025-05-05 16:17:41+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (4, 'Rhoda Potter', 'xypyfyqiw@mailinator.com', '$2y$10$rzuSet4Bl/qy9Au/WTu97uMhtMHfalwe2UdFuHOLsVTHVAZWoW1g2', 'agent', '2025-05-04 17:48:38+00', '2025-05-04 17:48:38+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (5, 'Aretha Hebert', 'xasumybug@mailinator.com', '$2y$10$eX6UkzOocf6e/V26QVRpEuDZ32Il/F/6QOnmX0Wk7G67fgZCYuJra', 'admin', '2025-05-04 17:49:02+00', '2025-05-04 17:49:02+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (10, 'Quamar Lindsey', 'qale@mailinator.com', '$2y$10$WkvpLhi9f2yrGj1FUcDGNOa3f5lMNsJmiQoEPRFXrXL8erR9adVYK', 'agent', '2025-05-05 01:31:50+00', '2025-05-05 01:31:50+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (15, 'Fulton Walter', 'pagupe@mailinator.com', '$2y$10$P7P14MBrc1lNV1wNGXkdiOP.Z94iqDCmKFfq8oz7CnKVqA2RPwpG.', 'admin', '2025-05-10 01:42:12+00', '2025-05-10 01:42:12+00');
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES (8, 'Amelia Tate', 'betegavil@mailinator.com', '$2y$10$Nydb0JQIuBb2grzmMZzod.Gqh0lk4UVM6ju9.sCiJB8c/.0iRfjFu', 'agent', '2025-05-04 18:07:04+00', '2025-05-04 18:07:04+00');
