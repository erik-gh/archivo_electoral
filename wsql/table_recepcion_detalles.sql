--
-- Table structure for table `recepcion_detalles`
--

DROP TABLE IF EXISTS `recepcion_detalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recepcion_detalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_recdoc` bigint(20) unsigned DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recepcion_detalles_id_recdoc_foreign` (`id_recdoc`),
  CONSTRAINT `recepcion_detalles_id_recdoc_foreign` FOREIGN KEY (`id_recdoc`) REFERENCES `recepcion_documentos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;