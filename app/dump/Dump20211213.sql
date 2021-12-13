-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_apitest_club
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `clubes`
--

LOCK TABLES `clubes` WRITE;
/*!40000 ALTER TABLE `clubes` DISABLE KEYS */;
INSERT INTO `clubes` VALUES (1,'Caracas FC','Club de prueba',15154444.56,15152969.55,1),(2,'Tachira FC','Club de prueba 2',2054845.54,2045245.54,1),(3,'Petare FC','Club de prueba 3',15555.56,15413.36,1),(4,'Carabobo FC','Club de prueba 4',125.56,125.56,1),(5,'Deportivo Tachira FC','Club de prueba 4',125.56,125.56,1),(6,'Alianza Lima','Club de prueba 5',8454441.56,8454441.56,1);
/*!40000 ALTER TABLE `clubes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `entrenadores`
--

LOCK TABLES `entrenadores` WRITE;
/*!40000 ALTER TABLE `entrenadores` DISABLE KEYS */;
INSERT INTO `entrenadores` VALUES (1,1,'Diego','Dudamel','Entrenador suplente','diegodudamel@gmail.com','+51',935351555,420.00,1,13587741),(2,NULL,'Mario','Lara','Entrenador suplente','mariolara@gmail.com','+51',935351555,220.00,1,47660575),(3,1,'Ricarfo','Gareca','Entrenador de la seleccion de Peru','gareca@gmail.com','+51',935351555,600.00,1,48745244),(4,2,'Memo','Morales','Entrenador suplente','memo@gmail.com','+51',935351555,600.00,1,47745144),(5,2,'Andree','Paez','Entrenador principal','andree@gmail.com','+51',935351555,600.00,1,14872142),(6,NULL,'Jose','Aranguibel','Entrenador suplente','jose@gmail.com','+51',935351555,600.00,1,18134988),(7,NULL,'Pedro','Martinez','Entrenador principal','pedro@gmail.com','+51',935351555,600.00,1,17740144),(8,NULL,'Juan','Melo','Entrenador suplente','juan@gmail.com','+51',935351555,600.00,1,20544144),(9,NULL,'Carlos','Aran','Entrenador principal','carlos@gmail.com','+51',935351555,600.00,1,18740141),(10,NULL,'Gustavo','Gonzalez','Entrenador principal','gustavo@gmail.com','+51',935351555,600.00,1,18740142),(11,NULL,'Antonio','Romero','Entrenador principal','antonio@gmail.com','+51',935351555,600.00,1,18140143),(12,NULL,'Hector','Mendoza','Entrenador principal','hector@gmail.com','+51',935351555,600.00,1,18740144),(13,NULL,'Fabrizio','Contreras','Entrenador principal','fabrizio@gmail.com','+51',935351555,600.00,1,18240145),(14,NULL,'Fernando','Conopoy','Entrenador principal','fernando@gmail.com','+51',935351555,600.00,1,18740146),(15,NULL,'Patricio','Hernandez','Entrenador principal','patricio@gmail.com','+51',935351555,600.00,1,18540147),(16,NULL,'Marlon','Quientero','Entrenador principal','marlon@gmail.com','+51',935351555,600.00,1,18740148),(17,NULL,'Jose','Ramirez','Entrenador principal','joses@gmail.com','+51',935351555,600.00,1,18840149),(18,NULL,'Ruben','Noroño','Entrenador principal','ruben@gmail.com','+51',935351555,600.00,1,18740110),(19,NULL,'Fernando','Morales','Entrenador principal','fern@gmail.com','+51',935351555,600.00,1,18240111),(20,NULL,'Stheven','Romero','Entrenador principal','stheven@gmail.com','+51',935351555,600.00,1,18740112);
/*!40000 ALTER TABLE `entrenadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jugadores`
--

LOCK TABLES `jugadores` WRITE;
/*!40000 ALTER TABLE `jugadores` DISABLE KEYS */;
INSERT INTO `jugadores` VALUES (1,3,'Antonio','Echenique','ajecheniqueavilaguillen@gmail.com','+51',935351933,18,'Delantero',142.20,1,18134979),(2,1,'Gelber','Guillen','gelberguillen@gmail.com','+51',935351933,28,'Delantero',155.01,1,48997079),(3,NULL,'Diego','Clemente','diegoclemente@gmail.com','+51',935351555,2,'Delantero',152.01,1,33254877),(4,1,'Manuel','Guillen','manuelguilen@gmail.com','+51',935351555,0,'Aguador',100.00,1,48997077),(5,1,'Rosimar','Contreras','rosmarcontreras@gmail.com','+51',935351555,0,'Animadora',20.00,1,18164977),(6,1,'Leonardo','Aranguibel','leoaranguibel@gmail.com','+51',935351555,30,'Portero',180.00,1,30588881);
/*!40000 ALTER TABLE `jugadores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-13  0:54:10
