CREATE TABLE "public"."ticket_history" ( 
  "id" SERIAL,
  "ticket_id" INTEGER NOT NULL,
  "changed_by" INTEGER NOT NULL,
  "field_changed" VARCHAR(50) NOT NULL,
  "old_value" TEXT NULL,
  "new_value" TEXT NULL,
  "changed_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  CONSTRAINT "ticket_history_pkey" PRIMARY KEY ("id"),
  CONSTRAINT "ticket_history_changed_by_fkey" FOREIGN KEY ("changed_by") REFERENCES "public"."users" ("id"),
  CONSTRAINT "ticket_history_ticket_id_fkey" FOREIGN KEY ("ticket_id") REFERENCES "public"."tickets" ("id")
);

