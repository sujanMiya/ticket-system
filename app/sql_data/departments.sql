CREATE TABLE "public"."departments" ( 
  "id" SERIAL,
  "name" VARCHAR(100) NOT NULL,
  "description" TEXT NULL,
  "created_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  CONSTRAINT "departments_pkey" PRIMARY KEY ("id")
);

INSERT INTO departments (id, name, description, created_at) VALUES (1, 'Operating system issues', 'Operating system issues', '2025-05-05 17:39:02.28533+00');
INSERT INTO departments (id, name, description, created_at) VALUES (2, 'WIFI', 'WIFI', '2025-05-05 18:22:56.350712+00');
