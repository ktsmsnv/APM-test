-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 192.168.60.35:3306
-- Время создания: Дек 13 2023 г., 11:39
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `APM`
--

-- --------------------------------------------------------

--
-- Структура таблицы `base_risks`
--

CREATE TABLE `base_risks` (
  `id` bigint UNSIGNED NOT NULL,
  `nameRisk` varchar(255) DEFAULT NULL,
  `reasonRisk` json DEFAULT NULL,
  `conseqRiskOnset` json DEFAULT NULL,
  `counteringRisk` json DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `riskManagMeasures` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `base_risks`
--

INSERT INTO `base_risks` (`id`, `nameRisk`, `reasonRisk`, `conseqRiskOnset`, `counteringRisk`, `term`, `riskManagMeasures`, `created_at`, `updated_at`) VALUES
(60, 'риск1', '\"[{\\\"reasonRisk\\\":\\\"\\\\u043f\\\\u0440\\\\u0438\\\\u0447\\\\u0438\\\\u043d\\\\u04301\\\"},{\\\"reasonRisk\\\":\\\"\\\\u043f\\\\u0440\\\\u0438\\\\u0447\\\\u0438\\\\u043d\\\\u04302\\\"}]\"', '\"[{\\\"conseqRiskOnset\\\":\\\"\\\\u043f\\\\u043e\\\\u0441\\\\u043b\\\\u0435\\\\u0434\\\\u0441\\\\u0442\\\\u0432\\\\u0438\\\\u044f1\\\"}]\"', '\"[{\\\"counteringRisk\\\":\\\"\\\\u043f\\\\u0440\\\\u043e\\\\u0442\\\\u0438\\\\u04321\\\"},{\\\"counteringRisk\\\":\\\"\\\\u043f\\\\u0440\\\\u043e\\\\u0442\\\\u0438\\\\u04322\\\"}]\"', 'срок', '\"[{\\\"riskManagMeasures\\\":\\\"\\\\u043c\\\\u0435\\\\u0440\\\\u043e\\\\u043f\\\\u0440\\\\u0438\\\\u044f\\\\u0442\\\\u0438\\\\u044f1\\\"}]\"', '2023-12-04 09:19:43', '2023-12-04 09:20:56'),
(61, 'риск2', '\"[{\\\"reasonRisk\\\":\\\"\\\\u043f\\\\u0440\\\\u0438\\\\u0447\\\\u0438\\\\u043d\\\\u04302\\\"}]\"', '\"[{\\\"conseqRiskOnset\\\":\\\"\\\\u043f\\\\u043e\\\\u0441\\\\u043b\\\\u0435\\\\u0434\\\\u0441\\\\u0442\\\\u0432\\\\u0438\\\\u044f2\\\"}]\"', '\"[{\\\"counteringRisk\\\":\\\"\\\\u043f\\\\u0440\\\\u043e\\\\u0442\\\\u0438\\\\u0432\\\\u043e\\\\u0434\\\\u0435\\\\u0441\\\\u0439\\\\u0442\\\\u0432\\\\u0438\\\\u04352\\\"}]\"', 'срок', '\"[{\\\"riskManagMeasures\\\":\\\"\\\\u043c\\\\u0435\\\\u0440\\\\u043e\\\\u043f\\\\u0440\\\\u0438\\\\u044f\\\\u0442\\\\u0438\\\\u044f2\\\"}]\"', '2023-12-04 09:20:36', '2023-12-04 09:20:36');

-- --------------------------------------------------------

--
-- Структура таблицы `basic_info`
--

CREATE TABLE `basic_info` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) DEFAULT NULL,
  `contractor` varchar(255) DEFAULT NULL,
  `contract_num` varchar(255) DEFAULT NULL,
  `price_plan` decimal(8,2) DEFAULT NULL,
  `price_fact` decimal(8,2) DEFAULT NULL,
  `contract_price` decimal(8,2) DEFAULT NULL,
  `profit_plan` decimal(8,2) DEFAULT NULL,
  `profit_fact` decimal(8,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date_plan` date DEFAULT NULL,
  `end_date_fact` date DEFAULT NULL,
  `complaint` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `basic_info`
--

INSERT INTO `basic_info` (`id`, `project_num`, `contractor`, `contract_num`, `price_plan`, `price_fact`, `contract_price`, `profit_plan`, `profit_fact`, `start_date`, `end_date_plan`, `end_date_fact`, `complaint`, `created_at`, `updated_at`) VALUES
(6, '1-23СИ', 'Титан-2', '555', '2111.10', '2000.00', '35000.00', '32888.90', '33000.00', '2023-11-11', '2023-12-01', '2023-11-08', 'рекламация 1', '2023-11-16 04:36:01', '2023-12-06 07:00:39'),
(11, '3-23 ЭОБ', 'контрагент3', '303', '1231.00', '18400.00', '10500.00', '9269.00', '-7900.00', '2023-12-01', '2023-12-14', '2023-12-16', 'рекламация3', '2023-12-07 02:35:57', '2023-12-07 02:35:57');

-- --------------------------------------------------------

--
-- Структура таблицы `basic_reference`
--

CREATE TABLE `basic_reference` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `projName` varchar(255) NOT NULL,
  `projCustomer` varchar(255) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `projGoal` varchar(255) NOT NULL,
  `projCurator` varchar(255) NOT NULL,
  `projManager` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `basic_reference`
--

INSERT INTO `basic_reference` (`id`, `project_num`, `projName`, `projCustomer`, `startDate`, `endDate`, `projGoal`, `projCurator`, `projManager`, `created_at`, `updated_at`) VALUES
(9, '1-23СИ', 'наим1', 'Концерн Росэнергоатом', '2023-11-11', '2023-12-01', 'Получение ожидаемой выгоды/прибыли от реализации проекта', '21', 'Юндер2 С.В.', '2023-11-16 04:36:01', '2023-12-06 07:00:39'),
(15, '3-23 ЭОБ', 'наименование 3', 'заказчик3', '2023-12-01', '2023-12-14', 'Получение ожидаемой выгоды/прибыли от реализации проекта', 'куратор 3', 'руководитель3', '2023-12-07 02:35:57', '2023-12-07 02:35:57');

-- --------------------------------------------------------

--
-- Структура таблицы `calc_risks`
--

CREATE TABLE `calc_risks` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `calcRisk_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `calc_risks`
--

INSERT INTO `calc_risks` (`id`, `project_num`, `calcRisk_name`, `created_at`, `updated_at`) VALUES
(3, '2-23 НХРС', 'риск 2.1', NULL, NULL),
(6, '1-23СИ', 'риск 1.11', NULL, '2023-12-06 06:35:42'),
(7, '1-23СИ', 'риск 1.21', NULL, '2023-12-06 06:35:42'),
(8, '3-23 ЭОБ', 'риск 3.1', NULL, NULL),
(9, '3-23 ЭОБ', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `changes`
--

CREATE TABLE `changes` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) DEFAULT NULL,
  `contractor` varchar(255) NOT NULL,
  `contract_num` varchar(255) NOT NULL,
  `change` varchar(255) NOT NULL,
  `impact` varchar(255) NOT NULL,
  `stage` varchar(255) NOT NULL,
  `corrective` varchar(255) NOT NULL,
  `responsible` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `changes`
--

INSERT INTO `changes` (`id`, `project_num`, `contractor`, `contract_num`, `change`, `impact`, `stage`, `corrective`, `responsible`, `created_at`, `updated_at`) VALUES
(9, '1-23СИ', 'Титан-2', '555', 'изменение1', 'влияние1', 'этап1', 'действие1', 'Юндер2 С.В.', NULL, '2023-12-06 07:02:02'),
(10, '1-23СИ', 'Титан-2', '555', 'изменение2', 'bbb', 'bbb', 'bbb', 'Юндер2 С.В.', NULL, '2023-12-06 07:02:02'),
(11, '1-23СИ', 'Титан-2', '555', 'изменение3', 'сс', 'сс', 'сс', 'Юндер2 С.В.', '2023-11-28 02:57:28', '2023-12-06 07:02:02'),
(12, '1-23СИ', 'Титан-2', '555', 'изменение4', 'влияние4', 'этап4', 'действие4', 'Юндер2 С.В.', '2023-12-06 07:02:26', '2023-12-06 07:02:26'),
(13, '3-23 ЭОБ', 'контрагент3', '303', '11', '11', '11', '11', 'руководитель3', NULL, '2023-12-07 07:51:52'),
(14, '3-23 ЭОБ', 'контрагент3', '303', '2', '2', '2', '2', 'руководитель3', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL,
  `responsibility` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `project_num`, `fio`, `post`, `responsibility`, `contact`, `created_at`, `updated_at`) VALUES
(60, '2-23 НХРС', 'фио21', 'должность21', 'ответ21', 'тел21', NULL, NULL),
(66, '1-23СИ', 'ФИО 1.12', 'должность 1.12', 'зона 1.12', 'тел 1.12', NULL, NULL),
(67, '3-23 ЭОБ', 'фио 3.1', 'должность 3.1', 'ответственность 3.1', 'телефон 3.1', NULL, NULL),
(68, '3-23 ЭОБ', '1', '1', '1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `equipment`
--

CREATE TABLE `equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `nameTMC` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `count` int NOT NULL,
  `priceUnit` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `equipment`
--

INSERT INTO `equipment` (`id`, `project_num`, `nameTMC`, `manufacture`, `unit`, `count`, `priceUnit`, `price`, `created_at`, `updated_at`) VALUES
(1, '1-23СИ', 'наим тмц 1.1', 'производитель 1.12', 'ед изм 1.12', 2, '200.55', '401.10', NULL, '2023-12-06 06:35:42'),
(2, '1-23СИ', 'наим тмц 1.2', 'производитель 1.22', 'ед изм 1.22', 2, '105.00', '210.00', NULL, '2023-12-06 06:35:42'),
(3, '2-23 НХРС', 'тмц2', 'производитель2', 'едизм2', 2, '11000.00', '22000.00', NULL, '2023-12-06 06:10:36'),
(6, '3-23 ЭОБ', 'тмц3', 'производитель3', 'едизм3', 3, '300.00', '900.00', NULL, NULL),
(7, '3-23 ЭОБ', '1', '1', '1', 1, '1.00', '1.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `commandir` varchar(255) NOT NULL,
  `rd` varchar(255) NOT NULL,
  `shmr` varchar(255) NOT NULL,
  `pnr` varchar(255) NOT NULL,
  `cert` varchar(255) NOT NULL,
  `delivery` varchar(255) NOT NULL,
  `rastam` varchar(255) NOT NULL,
  `ppo` varchar(255) NOT NULL,
  `guarantee` varchar(255) NOT NULL,
  `check` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `expenses`
--

INSERT INTO `expenses` (`id`, `project_num`, `commandir`, `rd`, `shmr`, `pnr`, `cert`, `delivery`, `rastam`, `ppo`, `guarantee`, `check`, `total`, `created_at`, `updated_at`) VALUES
(1, '1-23СИ', '150', '150', '150', '150', '150', '150', '150', '150', '150', '150', '1500', '2023-11-15 04:53:14', '2023-11-27 02:46:50'),
(2, '2-23 НХРС', '11', '2', '2', '2', '2', '2', '2', '2', '2', '11', '38', '2023-11-23 06:30:53', '2023-12-06 06:10:36'),
(4, '3-23 ЭОБ', '33', '33', '33', '33', '33', '33', '33', '33', '33', '33', '330', '2023-12-07 02:05:01', '2023-12-07 02:05:01');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `markups`
--

CREATE TABLE `markups` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `priceSubTkp` decimal(10,2) DEFAULT NULL,
  `agreedFio` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `markups`
--

INSERT INTO `markups` (`id`, `project_num`, `date`, `percentage`, `priceSubTkp`, `agreedFio`, `created_at`, `updated_at`) VALUES
(60, '2-23 НХРС', '2023-11-02', '12.00', '13600.00', 'фио21', NULL, NULL),
(66, '1-23СИ', '2023-12-01', '20.00', '12000.25', 'ФИО 1.12', NULL, NULL),
(67, '3-23 ЭОБ', '2023-12-01', '30.00', '13500.00', 'фио3', NULL, NULL),
(68, '3-23 ЭОБ', '2023-12-01', '1.00', '1.00', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(24, '2014_10_12_000000_create_users_table', 1),
(25, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(26, '2014_10_12_100000_create_password_resets_table', 1),
(27, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(29, '2023_11_02_051647_create_registry_eob_table', 1),
(30, '2023_11_03_070950_create_projects_table', 1),
(31, '2023_11_03_072018_create_equipment_table', 1),
(32, '2023_11_03_072405_create_markup_table', 1),
(33, '2023_11_03_072508_create_contacts_table', 1),
(34, '2023_11_03_072547_create_risks_table', 1),
(35, '2023_11_07_043623_create_expenses_table', 1),
(36, '2023_11_08_072244_create_registry_sinteg_table', 1),
(37, '2023_11_08_072433_create_registry_nhrs_table', 1),
(38, '2023_11_08_072506_create_registry_other_table', 1),
(39, '2023_11_09_080000_create_notes_table', 1),
(40, '2023_11_10_063304_create_workgroup_table', 1),
(41, '2023_11_13_101038_create_totals_table', 1),
(42, '2023_11_13_101039_create_basic_reference_table', 1),
(43, '2023_11_13_101046_create_basic_info_table', 1),
(44, '2023_11_13_102906_create_changes_table', 1),
(45, '2023_11_14_102220_create_reestr__k_p_table', 1),
(46, '2023_11_14_102612_create_registry_reestr_k_p_table', 1),
(47, '2023_11_14_102759_create_reg_reestr_k_p_s_table', 1),
(48, '2023_11_17_042156_create_base_risks_table', 2),
(49, '2023_11_20_072459_create_report_table', 3),
(50, '2023_11_21_050812_create_report_team_table', 4),
(51, '2023_11_21_071537_create_report_reflection_table', 5),
(52, '2023_11_21_092823_create_report_notes_table', 6),
(53, '2023_11_28_042156_create_base_risks_table', 7),
(54, '2023_11_29_042156_create_base_risks_table', 8),
(55, '2023_12_04_123149_create_risks_table', 9),
(56, '2023_12_06_091506_create_calc_risks_table', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `notes`
--

CREATE TABLE `notes` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `comment` text,
  `project_num` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `notes`
--

INSERT INTO `notes` (`id`, `date`, `comment`, `project_num`, `created_at`, `updated_at`) VALUES
(1, '2023-11-16', 'запись тест 1', '1-23СИ', '2023-11-16 04:50:04', '2023-11-16 04:50:04'),
(6, '2023-12-07', '111', '3-23 ЭОБ', '2023-12-07 04:25:47', '2023-12-07 04:25:47');

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `projNum` varchar(255) NOT NULL,
  `projManager` varchar(255) NOT NULL,
  `objectName` varchar(255) NOT NULL,
  `endCustomer` varchar(255) NOT NULL,
  `contractor` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `projNum`, `projManager`, `objectName`, `endCustomer`, `contractor`, `created_at`, `updated_at`) VALUES
(1, '1-23СИ', 'Юндер2 С.В.', 'ZPU-22-002', 'Концерн Росэнергоатом', 'Титан-2', '2023-11-15 04:53:14', '2023-11-28 02:57:46'),
(8, '2-23 НХРС', 'руководитель2', 'наим2', 'заказчик2', 'контрагент2', '2023-11-23 06:30:53', '2023-12-06 06:09:31'),
(10, '3-23 ЭОБ', 'руководитель3', 'наименование3', 'заказчик3', 'контрагент3', '2023-12-07 02:05:01', '2023-12-07 02:05:01');

-- --------------------------------------------------------

--
-- Структура таблицы `reestr_KP`
--

CREATE TABLE `reestr_KP` (
  `id` bigint UNSIGNED NOT NULL,
  `numIncoming` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `orgName` varchar(255) NOT NULL,
  `whom` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `amountNDS` varchar(255) NOT NULL,
  `purchNum` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `registry_eob`
--

CREATE TABLE `registry_eob` (
  `id` bigint UNSIGNED NOT NULL,
  `vnNum` varchar(255) NOT NULL,
  `purchaseName` varchar(255) NOT NULL,
  `delivery` tinyint(1) DEFAULT NULL,
  `pir` tinyint(1) DEFAULT NULL,
  `kd` tinyint(1) DEFAULT NULL,
  `prod` tinyint(1) DEFAULT NULL,
  `shmr` tinyint(1) DEFAULT NULL,
  `pnr` tinyint(1) DEFAULT NULL,
  `po` tinyint(1) DEFAULT NULL,
  `smr` tinyint(1) DEFAULT NULL,
  `purchaseOrg` varchar(255) NOT NULL,
  `endUser` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `receiptDate` date NOT NULL,
  `submissionDate` date NOT NULL,
  `projectManager` varchar(255) NOT NULL,
  `tech` varchar(255) NOT NULL,
  `primeCost` text NOT NULL,
  `tkpCost` varchar(255) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `registry_nhrs`
--

CREATE TABLE `registry_nhrs` (
  `id` bigint UNSIGNED NOT NULL,
  `vnNum` varchar(255) NOT NULL,
  `purchaseName` varchar(255) NOT NULL,
  `delivery` tinyint(1) DEFAULT NULL,
  `pir` tinyint(1) DEFAULT NULL,
  `kd` tinyint(1) DEFAULT NULL,
  `prod` tinyint(1) DEFAULT NULL,
  `shmr` tinyint(1) DEFAULT NULL,
  `pnr` tinyint(1) DEFAULT NULL,
  `po` tinyint(1) DEFAULT NULL,
  `smr` tinyint(1) DEFAULT NULL,
  `purchaseOrg` varchar(255) NOT NULL,
  `endUser` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `receiptDate` date NOT NULL,
  `submissionDate` date NOT NULL,
  `projectManager` varchar(255) NOT NULL,
  `tech` varchar(255) NOT NULL,
  `primeCost` text NOT NULL,
  `tkpCost` varchar(255) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `registry_other`
--

CREATE TABLE `registry_other` (
  `id` bigint UNSIGNED NOT NULL,
  `vnNum` varchar(255) NOT NULL,
  `purchaseName` varchar(255) NOT NULL,
  `delivery` tinyint(1) DEFAULT NULL,
  `pir` tinyint(1) DEFAULT NULL,
  `kd` tinyint(1) DEFAULT NULL,
  `prod` tinyint(1) DEFAULT NULL,
  `shmr` tinyint(1) DEFAULT NULL,
  `pnr` tinyint(1) DEFAULT NULL,
  `po` tinyint(1) DEFAULT NULL,
  `smr` tinyint(1) DEFAULT NULL,
  `purchaseOrg` varchar(255) NOT NULL,
  `endUser` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `receiptDate` date NOT NULL,
  `submissionDate` date NOT NULL,
  `projectManager` varchar(255) NOT NULL,
  `tech` varchar(255) NOT NULL,
  `primeCost` text NOT NULL,
  `tkpCost` varchar(255) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `registry_reestrKP`
--

CREATE TABLE `registry_reestrKP` (
  `id` bigint UNSIGNED NOT NULL,
  `numIncoming` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `orgName` varchar(255) NOT NULL,
  `whom` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `amountNDS` varchar(255) NOT NULL,
  `purchNum` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `registry_sinteg`
--

CREATE TABLE `registry_sinteg` (
  `id` bigint UNSIGNED NOT NULL,
  `vnNum` varchar(255) NOT NULL,
  `purchaseName` varchar(255) NOT NULL,
  `delivery` varchar(1) DEFAULT NULL,
  `pir` varchar(1) DEFAULT NULL,
  `kd` tinyint(1) DEFAULT NULL,
  `prod` tinyint(1) DEFAULT NULL,
  `shmr` varchar(1) DEFAULT NULL,
  `pnr` tinyint(1) DEFAULT NULL,
  `po` tinyint(1) DEFAULT NULL,
  `smr` tinyint(1) DEFAULT NULL,
  `purchaseOrg` varchar(255) NOT NULL,
  `endUser` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `receiptDate` date NOT NULL,
  `submissionDate` date NOT NULL,
  `projectManager` varchar(255) NOT NULL,
  `tech` varchar(255) NOT NULL,
  `primeCost` text NOT NULL,
  `tkpCost` varchar(255) NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `registry_sinteg`
--

INSERT INTO `registry_sinteg` (`id`, `vnNum`, `purchaseName`, `delivery`, `pir`, `kd`, `prod`, `shmr`, `pnr`, `po`, `smr`, `purchaseOrg`, `endUser`, `object`, `area`, `receiptDate`, `submissionDate`, `projectManager`, `tech`, `primeCost`, `tkpCost`, `notes`, `created_at`, `updated_at`) VALUES
(1, '1-23СИ', 'ZPU-22-002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Титан-2', 'Концерн Росэнергоатом', 'Ленинградская АЭС-2', 'Фабрикант', '2023-02-11', '2023-01-27', 'Юндер С.В.', '', '', '', NULL, NULL, NULL),
(2, '2-23СИ', 'РН30100938 АСУТП Базы ГСМ', '+', NULL, NULL, NULL, '+', NULL, NULL, NULL, 'ПАО НК Роснефть', 'ПАО НК Роснефть', 'База ГСМ Пурнефтепереработка', '', '2023-01-12', '2023-11-27', 'Юндер С.В.', '', '', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `costRubW` json DEFAULT NULL,
  `costRub` json DEFAULT NULL,
  `expenseDirectPlan` varchar(255) DEFAULT NULL,
  `expenseMaterialPlan` varchar(255) DEFAULT NULL,
  `expenseDeliveryPlan` varchar(255) DEFAULT NULL,
  `expenseWorkPlan` varchar(255) DEFAULT NULL,
  `expenseOtherPlan` varchar(255) DEFAULT NULL,
  `expenseOpoxPlan` varchar(255) DEFAULT NULL,
  `marginProfitPlan` varchar(255) DEFAULT NULL,
  `marginalityPlan` varchar(255) DEFAULT NULL,
  `profitPlan` varchar(255) DEFAULT NULL,
  `projProfitPlan` varchar(255) DEFAULT NULL,
  `expenseDirectFact` varchar(255) DEFAULT NULL,
  `expenseMaterialFact` varchar(255) DEFAULT NULL,
  `expenseDeliveryFact` varchar(255) DEFAULT NULL,
  `expenseWorkFact` varchar(255) DEFAULT NULL,
  `expenseOtherFact` varchar(255) DEFAULT NULL,
  `expenseOpoxFact` varchar(255) DEFAULT NULL,
  `marginProfitFact` varchar(255) DEFAULT NULL,
  `marginalityFact` varchar(255) DEFAULT NULL,
  `profitFact` varchar(255) DEFAULT NULL,
  `projProfitFact` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `reports`
--

INSERT INTO `reports` (`id`, `project_num`, `costRubW`, `costRub`, `expenseDirectPlan`, `expenseMaterialPlan`, `expenseDeliveryPlan`, `expenseWorkPlan`, `expenseOtherPlan`, `expenseOpoxPlan`, `marginProfitPlan`, `marginalityPlan`, `profitPlan`, `projProfitPlan`, `expenseDirectFact`, `expenseMaterialFact`, `expenseDeliveryFact`, `expenseWorkFact`, `expenseOtherFact`, `expenseOpoxFact`, `marginProfitFact`, `marginalityFact`, `profitFact`, `projProfitFact`, `created_at`, `updated_at`) VALUES
(19, '1-23СИ', '42000', '42000', '1', '1', '2', '2', '2', '1', '33573.24', '1', '33572.24', '1', '13', '3', '3', '3', '3', '1', '41987', '1', '41986', '1', '2023-11-23 03:02:45', '2023-11-24 07:08:38');

-- --------------------------------------------------------

--
-- Структура таблицы `report_notes`
--

CREATE TABLE `report_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `projNotes` varchar(255) DEFAULT NULL,
  `teamNotes` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `report_notes`
--

INSERT INTO `report_notes` (`id`, `project_num`, `projNotes`, `teamNotes`, `resume`, `created_at`, `updated_at`) VALUES
(11, '1-23СИ', 'прим1', 'прим2', 'резюме1', '2023-11-23 03:02:45', '2023-11-23 03:02:45'),
(17, '1-23СИ', 'прим1', 'прим21', 'резюме1', '2023-11-24 07:08:15', '2023-11-24 07:08:15'),
(18, '1-23СИ', 'прим1', 'прим2', 'резюме1', '2023-11-24 07:08:38', '2023-11-24 07:08:38');

-- --------------------------------------------------------

--
-- Структура таблицы `report_reflection`
--

CREATE TABLE `report_reflection` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `devRKD_adv` varchar(255) DEFAULT NULL,
  `complection_adv` varchar(255) DEFAULT NULL,
  `production_adv` varchar(255) DEFAULT NULL,
  `shipment_adv` varchar(255) DEFAULT NULL,
  `devRKD_dis` varchar(255) DEFAULT NULL,
  `complection_dis` varchar(255) DEFAULT NULL,
  `production_dis` varchar(255) DEFAULT NULL,
  `shipment_dis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `report_reflection`
--

INSERT INTO `report_reflection` (`id`, `project_num`, `devRKD_adv`, `complection_adv`, `production_adv`, `shipment_adv`, `devRKD_dis`, `complection_dis`, `production_dis`, `shipment_dis`, `created_at`, `updated_at`) VALUES
(11, '1-23СИ', '1', '1', '1', '1', '1', '1', '1', '1', '2023-11-23 03:02:45', '2023-11-23 03:02:45');

-- --------------------------------------------------------

--
-- Структура таблицы `report_team`
--

CREATE TABLE `report_team` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `roleFio` varchar(255) DEFAULT NULL,
  `roleDescription` varchar(255) DEFAULT NULL,
  `roleImpact` varchar(255) DEFAULT NULL,
  `roleBonus` varchar(255) DEFAULT NULL,
  `premium_part` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `report_team`
--

INSERT INTO `report_team` (`id`, `project_num`, `roleFio`, `roleDescription`, `roleImpact`, `roleBonus`, `premium_part`, `created_at`, `updated_at`) VALUES
(18, '1-23СИ', 'фио1', 'Ведение проекта', '100%', '35000', '350', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `risks`
--

CREATE TABLE `risks` (
  `id` bigint UNSIGNED NOT NULL,
  `risk_name` varchar(255) DEFAULT NULL,
  `risk_reason` json DEFAULT NULL,
  `risk_consequences` json DEFAULT NULL,
  `risk_probability` int DEFAULT NULL,
  `risk_influence` int DEFAULT NULL,
  `risk_estimate` int DEFAULT NULL,
  `risk_strategy` varchar(255) DEFAULT NULL,
  `risk_counteraction` json DEFAULT NULL,
  `risk_term` varchar(255) DEFAULT NULL,
  `risk_mark` varchar(255) DEFAULT NULL,
  `risk_measures` json DEFAULT NULL,
  `risk_responsible` varchar(255) DEFAULT NULL,
  `risk_endTerm` varchar(255) DEFAULT NULL,
  `project_num` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `risks`
--

INSERT INTO `risks` (`id`, `risk_name`, `risk_reason`, `risk_consequences`, `risk_probability`, `risk_influence`, `risk_estimate`, `risk_strategy`, `risk_counteraction`, `risk_term`, `risk_mark`, `risk_measures`, `risk_responsible`, `risk_endTerm`, `project_num`, `created_at`, `updated_at`) VALUES
(6, 'риск1', '[{\"reasonRisk\": \"причина1\"}, {\"reasonRisk\": \"причина2\"}]', '[{\"conseqRiskOnset\": \"последствия1\"}]', 4, 8, 32, 'принятие', '[{\"counteringRisk\": \"против2\"}]', 'срок', 'Выполнено', '[{\"riskManagMeasures\": \"мероприятия1\"}]', 'фио', '20', '1-23СИ', '2023-12-05 08:17:32', '2023-12-05 08:59:36'),
(17, 'риск1', '[{\"reasonRisk\": \"причина1\"}, {\"reasonRisk\": \"причина2\"}]', '[{\"conseqRiskOnset\": \"последствия1\"}]', 1, 2, 2, 'принятие', '[{\"counteringRisk\": \"против2\"}]', 'срок', 'Не выполнено', '[{\"riskManagMeasures\": \"мероприятия1\"}]', 'фио', '12', '3-23 ЭОБ', '2023-12-07 04:31:25', '2023-12-07 04:31:25'),
(18, 'риск2', '[{\"reasonRisk\": \"причина2\"}]', '[{\"conseqRiskOnset\": \"последствия2\"}]', 2, 2, 4, 'принятие', '[{\"counteringRisk\": \"противодесйтвие2\"}]', 'срок', 'Не выполнено', '[{\"riskManagMeasures\": \"мероприятия2\"}]', '1', '1', '1-23СИ', '2023-12-11 04:48:05', '2023-12-11 04:48:05');

-- --------------------------------------------------------

--
-- Структура таблицы `totals`
--

CREATE TABLE `totals` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) DEFAULT NULL,
  `kdDays` int DEFAULT NULL,
  `equipmentDays` int DEFAULT NULL,
  `productionDays` int DEFAULT NULL,
  `shipmentDays` int DEFAULT NULL,
  `periodDays` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `totals`
--

INSERT INTO `totals` (`id`, `project_num`, `kdDays`, `equipmentDays`, `productionDays`, `shipmentDays`, `periodDays`, `price`, `created_at`, `updated_at`) VALUES
(1, '1-23СИ', 2, 2, 2, 2, 8, '2111.10', '2023-11-15 04:53:14', '2023-12-06 06:35:42'),
(2, '2-23 НХРС', 3, 2, 5, 3, 13, '22038.00', '2023-11-23 06:30:53', '2023-12-06 06:10:36'),
(4, '3-23 ЭОБ', 3, 3, 2, 1, 9, '1231.00', '2023-12-07 02:05:01', '2023-12-07 02:05:01');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@mail.ru', NULL, '$2y$12$16HKydZkIy8QF7GtqKI7zux7lk540ej3UtMojzZFRcbUyWYZ/MtDS', '1VcjNYncjeTKdNbHYts8URCdWglViVVZsanfHTLkvwulBnLlY0okGBCnYz1B', '2023-11-15 04:43:30', '2023-11-15 04:43:30');

-- --------------------------------------------------------

--
-- Структура таблицы `workGroup`
--

CREATE TABLE `workGroup` (
  `id` bigint UNSIGNED NOT NULL,
  `project_num` varchar(255) NOT NULL,
  `projCurator` varchar(255) DEFAULT NULL,
  `projDirector` varchar(255) DEFAULT NULL,
  `techlid` varchar(255) DEFAULT NULL,
  `production` varchar(255) DEFAULT NULL,
  `supply` varchar(255) DEFAULT NULL,
  `logistics` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `workGroup`
--

INSERT INTO `workGroup` (`id`, `project_num`, `projCurator`, `projDirector`, `techlid`, `production`, `supply`, `logistics`, `created_at`, `updated_at`) VALUES
(3, '1-23СИ', '21', '1', '2', '2', '2', '2', '2023-11-16 04:36:01', '2023-12-06 07:00:39'),
(6, '2-23 НХРС', '1', '1', '1', '1', '1', '1', '2023-11-24 02:35:04', '2023-11-24 02:35:04'),
(7, '2-23 НХРС', '1', '1', '1', '1', '1', '1', '2023-11-24 03:48:21', '2023-11-24 03:48:21'),
(8, '3-23 ЭОБ', 'куратор 3', 'руководитель 3', 'техлид 3', 'производство 3', 'снабжение 3', 'логист 3', '2023-12-07 02:35:57', '2023-12-07 02:35:57');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `base_risks`
--
ALTER TABLE `base_risks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `basic_info`
--
ALTER TABLE `basic_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basic_info_project_num_foreign` (`project_num`),
  ADD KEY `basic_info_contractor_foreign` (`contractor`),
  ADD KEY `basic_info_price_plan_foreign` (`price_plan`),
  ADD KEY `basic_info_start_date_foreign` (`start_date`),
  ADD KEY `basic_info_end_date_plan_foreign` (`end_date_plan`),
  ADD KEY `basic_info_contract_num_index` (`contract_num`);

--
-- Индексы таблицы `basic_reference`
--
ALTER TABLE `basic_reference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `basic_reference_project_num_foreign` (`project_num`),
  ADD KEY `basic_reference_projcustomer_foreign` (`projCustomer`),
  ADD KEY `basic_reference_projmanager_foreign` (`projManager`),
  ADD KEY `basic_reference_startdate_index` (`startDate`),
  ADD KEY `basic_reference_enddate_index` (`endDate`);

--
-- Индексы таблицы `calc_risks`
--
ALTER TABLE `calc_risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calc_risks_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `changes`
--
ALTER TABLE `changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `changes_project_num_foreign` (`project_num`),
  ADD KEY `changes_contractor_foreign` (`contractor`),
  ADD KEY `changes_contract_num_foreign` (`contract_num`),
  ADD KEY `changes_responsible_foreign` (`responsible`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `markups`
--
ALTER TABLE `markups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `markups_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_projnum_unique` (`projNum`),
  ADD KEY `projects_projmanager_index` (`projManager`),
  ADD KEY `projects_endcustomer_index` (`endCustomer`),
  ADD KEY `projects_contractor_index` (`contractor`);

--
-- Индексы таблицы `reestr_KP`
--
ALTER TABLE `reestr_KP`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `registry_eob`
--
ALTER TABLE `registry_eob`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `registry_nhrs`
--
ALTER TABLE `registry_nhrs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `registry_other`
--
ALTER TABLE `registry_other`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `registry_reestrKP`
--
ALTER TABLE `registry_reestrKP`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `registry_sinteg`
--
ALTER TABLE `registry_sinteg`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `report_notes`
--
ALTER TABLE `report_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_notes_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `report_reflection`
--
ALTER TABLE `report_reflection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_reflection_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `report_team`
--
ALTER TABLE `report_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_team_project_num_foreign` (`project_num`);

--
-- Индексы таблицы `risks`
--
ALTER TABLE `risks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `risks_project_num_index` (`project_num`);

--
-- Индексы таблицы `totals`
--
ALTER TABLE `totals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `totals_project_num_foreign` (`project_num`),
  ADD KEY `totals_price_index` (`price`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `workGroup`
--
ALTER TABLE `workGroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workgroup_project_num_foreign` (`project_num`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `base_risks`
--
ALTER TABLE `base_risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT для таблицы `basic_info`
--
ALTER TABLE `basic_info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `basic_reference`
--
ALTER TABLE `basic_reference`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `calc_risks`
--
ALTER TABLE `calc_risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `changes`
--
ALTER TABLE `changes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT для таблицы `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `markups`
--
ALTER TABLE `markups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `reestr_KP`
--
ALTER TABLE `reestr_KP`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registry_eob`
--
ALTER TABLE `registry_eob`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registry_nhrs`
--
ALTER TABLE `registry_nhrs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registry_other`
--
ALTER TABLE `registry_other`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registry_reestrKP`
--
ALTER TABLE `registry_reestrKP`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `registry_sinteg`
--
ALTER TABLE `registry_sinteg`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `report_notes`
--
ALTER TABLE `report_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `report_reflection`
--
ALTER TABLE `report_reflection`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `report_team`
--
ALTER TABLE `report_team`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `risks`
--
ALTER TABLE `risks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `totals`
--
ALTER TABLE `totals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `workGroup`
--
ALTER TABLE `workGroup`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basic_info`
--
ALTER TABLE `basic_info`
  ADD CONSTRAINT `basic_info_contractor_foreign` FOREIGN KEY (`contractor`) REFERENCES `projects` (`contractor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `basic_info_end_date_plan_foreign` FOREIGN KEY (`end_date_plan`) REFERENCES `basic_reference` (`endDate`) ON UPDATE CASCADE,
  ADD CONSTRAINT `basic_info_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `basic_info_start_date_foreign` FOREIGN KEY (`start_date`) REFERENCES `basic_reference` (`startDate`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `basic_reference`
--
ALTER TABLE `basic_reference`
  ADD CONSTRAINT `basic_reference_projcustomer_foreign` FOREIGN KEY (`projCustomer`) REFERENCES `projects` (`endCustomer`) ON UPDATE CASCADE,
  ADD CONSTRAINT `basic_reference_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `basic_reference_projmanager_foreign` FOREIGN KEY (`projManager`) REFERENCES `projects` (`projManager`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `calc_risks`
--
ALTER TABLE `calc_risks`
  ADD CONSTRAINT `calc_risks_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`);

--
-- Ограничения внешнего ключа таблицы `changes`
--
ALTER TABLE `changes`
  ADD CONSTRAINT `changes_contract_num_foreign` FOREIGN KEY (`contract_num`) REFERENCES `basic_info` (`contract_num`) ON UPDATE CASCADE,
  ADD CONSTRAINT `changes_contractor_foreign` FOREIGN KEY (`contractor`) REFERENCES `projects` (`contractor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `changes_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE,
  ADD CONSTRAINT `changes_responsible_foreign` FOREIGN KEY (`responsible`) REFERENCES `projects` (`projManager`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`);

--
-- Ограничения внешнего ключа таблицы `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`);

--
-- Ограничения внешнего ключа таблицы `markups`
--
ALTER TABLE `markups`
  ADD CONSTRAINT `markups_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`);

--
-- Ограничения внешнего ключа таблицы `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`);

--
-- Ограничения внешнего ключа таблицы `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `report_notes`
--
ALTER TABLE `report_notes`
  ADD CONSTRAINT `report_notes_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `report_reflection`
--
ALTER TABLE `report_reflection`
  ADD CONSTRAINT `report_reflection_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `report_team`
--
ALTER TABLE `report_team`
  ADD CONSTRAINT `report_team_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `risks`
--
ALTER TABLE `risks`
  ADD CONSTRAINT `risks_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `totals`
--
ALTER TABLE `totals`
  ADD CONSTRAINT `totals_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `workGroup`
--
ALTER TABLE `workGroup`
  ADD CONSTRAINT `workgroup_project_num_foreign` FOREIGN KEY (`project_num`) REFERENCES `projects` (`projNum`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
