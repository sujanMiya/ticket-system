CREATE TABLE "public"."tickets" ( 
  "id" SERIAL,
  "subject" VARCHAR(255) NOT NULL,
  "description" TEXT NOT NULL,
  "status" VARCHAR(20) NOT NULL DEFAULT 'open'::character varying ,
  "priority" VARCHAR(20) NOT NULL DEFAULT 'medium'::character varying ,
  "customer_id" INTEGER NOT NULL,
  "assigned_agent_id" INTEGER NULL,
  "created_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  "updated_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  "department_id" INTEGER NULL,
  CONSTRAINT "tickets_pkey" PRIMARY KEY ("id"),
  CONSTRAINT "tickets_assigned_agent_id_fkey" FOREIGN KEY ("assigned_agent_id") REFERENCES "public"."users" ("id"),
  CONSTRAINT "tickets_customer_id_fkey" FOREIGN KEY ("customer_id") REFERENCES "public"."users" ("id"),
  CONSTRAINT "fk_tickets_department" FOREIGN KEY ("department_id") REFERENCES "public"."departments" ("id")
);
CREATE INDEX "idx_tickets_status" 
ON "public"."tickets" (
  "status" ASC
);
CREATE INDEX "idx_tickets_priority" 
ON "public"."tickets" (
  "priority" ASC
);
CREATE INDEX "idx_tickets_customer" 
ON "public"."tickets" (
  "customer_id" ASC
);
CREATE INDEX "idx_tickets_agent" 
ON "public"."tickets" (
  "assigned_agent_id" ASC
);

INSERT INTO tickets (id, subject, description, status, priority, customer_id, assigned_agent_id, created_at, updated_at, department_id) VALUES (2, 'Ea repudiandae modi ', 'Numquam aspernatur o', 'open', 'low', 14, NULL, '2025-05-05 21:39:36+00', '2025-05-05 21:39:36+00', 2);
INSERT INTO tickets (id, subject, description, status, priority, customer_id, assigned_agent_id, created_at, updated_at, department_id) VALUES (3, 'Nulla eum nostrum de', 'Facere iusto culpa q', 'open', 'medium', 14, NULL, '2025-05-05 21:40:47+00', '2025-05-05 21:40:47+00', 2);
INSERT INTO tickets (id, subject, description, status, priority, customer_id, assigned_agent_id, created_at, updated_at, department_id) VALUES (4, 'Qui animi doloremqu', 'Autem consectetur si', 'open', 'low', 14, NULL, '2025-05-06 04:15:50+00', '2025-05-06 04:15:50+00', 2);
INSERT INTO tickets (id, subject, description, status, priority, customer_id, assigned_agent_id, created_at, updated_at, department_id) VALUES (1, 'Dicta fugit occaeca', 'Doloribus consequunt', 'open', 'low', 13, NULL, '2025-05-05 21:38:16+00', '2025-05-05 21:38:16+00', 2);
INSERT INTO tickets (id, subject, description, status, priority, customer_id, assigned_agent_id, created_at, updated_at, department_id) VALUES (5, 'Placeat quis dolor ', 'Ipsam quidem quia en', 'open', 'medium', 14, 10, '2025-05-06 15:54:39+00', '2025-05-11 02:54:54+00', 2);
