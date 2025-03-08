CREATE TABLE IF NOT EXISTS `tarefas` (
  `id` int NOT NULL AUTO_INCREMENT, -- Adicione AUTO_INCREMENT aqui
  `tarefa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `concluido` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;