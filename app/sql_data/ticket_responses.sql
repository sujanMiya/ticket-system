CREATE TABLE "public"."ticket_responses" ( 
  "id" SERIAL,
  "ticket_id" INTEGER NOT NULL,
  "user_id" INTEGER NOT NULL,
  "message" TEXT NOT NULL,
  "is_internal_note" BOOLEAN NULL DEFAULT false ,
  "created_at" TIMESTAMP WITH TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP ,
  CONSTRAINT "ticket_responses_pkey" PRIMARY KEY ("id"),
  CONSTRAINT "ticket_responses_user_id_fkey" FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id"),
  CONSTRAINT "ticket_responses_ticket_id_fkey" FOREIGN KEY ("ticket_id") REFERENCES "public"."tickets" ("id")
);
CREATE INDEX "idx_responses_ticket" 
ON "public"."ticket_responses" (
  "ticket_id" ASC
);

INSERT INTO ticket_responses (id, ticket_id, user_id, message, is_internal_note, created_at) VALUES (1, 5, 10, 'Nesciunt voluptates', 0, '2025-05-11 02:54:54+00');
