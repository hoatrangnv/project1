-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 25, 2018 lúc 05:24 AM
-- Phiên bản máy phục vụ: 10.1.28-MariaDB
-- Phiên bản PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nclp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bonus_binary`
--

CREATE TABLE `bonus_binary` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `weeked` int(10) NOT NULL,
  `year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leftNew` double NOT NULL,
  `rightNew` double NOT NULL,
  `leftOpen` double DEFAULT '0',
  `rightOpen` double DEFAULT '0',
  `settled` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `bonus_tmp` double DEFAULT NULL,
  `weekYear` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bonus_faststart`
--

CREATE TABLE `bonus_faststart` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `generation` smallint(6) NOT NULL,
  `partnerId` int(10) NOT NULL,
  `packageId` int(10) NOT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `clp_api_logs`
--

CREATE TABLE `clp_api_logs` (
  `id` int(11) NOT NULL,
  `error_msg` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `clp_notification`
--

CREATE TABLE `clp_notification` (
  `id` int(10) NOT NULL,
  `data` text NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `completed_status` tinyint(1) DEFAULT NULL,
  `transaction_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `clp_wallets`
--

CREATE TABLE `clp_wallets` (
  `id` int(11) NOT NULL,
  `userId` int(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cron_binary_logs`
--

CREATE TABLE `cron_binary_logs` (
  `id` int(10) NOT NULL,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cron_matching_day_logs`
--

CREATE TABLE `cron_matching_day_logs` (
  `id` int(10) NOT NULL,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cron_profit_day_logs`
--

CREATE TABLE `cron_profit_day_logs` (
  `id` int(10) NOT NULL,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exchange_rates`
--

CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL,
  `from_currency` char(30) NOT NULL,
  `exchrate` double NOT NULL,
  `to_currency` char(30) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `exchange_rates`
--

INSERT INTO `exchange_rates` (`id`, `from_currency`, `exchrate`, `to_currency`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'clp', 1, 'usd', '2017-10-04 10:34:33', '2017-10-04 10:34:33', NULL),
(2, 'btc', 4210, 'usd', '2017-10-04 10:34:33', '2017-10-04 10:34:33', NULL),
(3, 'clp', 0.00023809524, 'btc', '2017-10-04 10:34:33', '2017-10-04 10:34:33', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2017_02_20_233057_create_permission_tables', 1),
(4, '2017_02_22_171712_create_posts_table', 1),
(23, '2014_10_12_000000_create_users_table', 2),
(24, '2014_10_12_100000_create_password_resets_table', 2),
(25, '2017_04_30_012311_create_posts_table', 2),
(26, '2017_04_30_014352_create_permission_tables', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES
(1, 1, 'App\\User'),
(2, 2, 'App\\User'),
(3, 3, 'App\\User');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` smallint(6) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `public_at` datetime DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `views` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `id` int(10) NOT NULL,
  `data` text NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `completed_status` tinyint(1) DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` smallint(6) NOT NULL,
  `bonus` float DEFAULT '0',
  `pack_id` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `packages`
--

INSERT INTO `packages` (`id`, `name`, `created_at`, `updated_at`, `thumb`, `price`, `bonus`, `pack_id`) VALUES
(1, 'TINY', '2017-08-16 00:06:07', '2017-09-17 21:14:44', NULL, 100, 0.0035, 1),
(2, 'SMALL', '2017-08-16 00:06:33', '2017-09-17 21:14:48', NULL, 500, 0.004, 2),
(3, 'MEDIUM', '2017-08-16 00:58:10', '2017-09-17 21:14:55', NULL, 1000, 0.0045, 3),
(4, 'LARGE', '2017-08-16 00:58:10', '2017-08-16 00:58:10', NULL, 2000, 0.005, 4),
(5, 'HUGE', '2017-08-16 00:58:10', '2017-08-16 00:58:10', NULL, 5000, 0.0055, 5),
(6, 'ANGEL', '2017-08-16 00:58:10', '2017-08-16 00:58:10', NULL, 10000, 0.006, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view_users', 'web', '2018-01-24 22:13:20', '2018-01-24 22:13:20'),
(2, 'add_users', 'web', '2018-01-24 22:13:20', '2018-01-24 22:13:20'),
(3, 'edit_users', 'web', '2018-01-24 22:13:20', '2018-01-24 22:13:20'),
(4, 'delete_users', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(5, 'view_roles', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(6, 'add_roles', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(7, 'edit_roles', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(8, 'delete_roles', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(9, 'view_posts', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(10, 'add_posts', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(11, 'edit_posts', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(12, 'delete_posts', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(13, 'view_reports', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(14, 'view_orders', 'web', '2018-01-24 22:13:21', '2018-01-24 22:13:21'),
(15, 'view_admins', 'web', '2018-01-24 22:13:22', '2018-01-24 22:13:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Alice; but she could not join the dance..', 'Caterpillar. \'Well, I can\'t put it more clearly,\' Alice replied very solemnly. Alice was just possible it had entirely disappeared; so the King replied. Here the other ladder?--Why, I hadn\'t to bring but one; Bill\'s got the other--Bill! fetch it here, lad!--Here, put \'em up at this moment Alice appeared, she was now more than Alice could think of nothing better to say to itself \'The Duchess! The Duchess! Oh my fur and whiskers! She\'ll get me executed, as sure as ferrets are ferrets! Where CAN I have done just as if she did not like to be afraid of interrupting him,) \'I\'ll give him sixpence. _I_ don\'t believe it,\' said the Lory, who at last in the distance, and she set to work nibbling at the stick, and made believe to worry it; then Alice put down her flamingo, and began to say it any longer than that,\' said the Rabbit coming to look over their slates; \'but it seems to be true): If she should push the matter worse. You MUST have meant some mischief, or else you\'d have signed your name.', 3, '2018-01-24 22:14:44', '2018-01-24 22:14:44'),
(2, 'But they HAVE their tails fast in their proper.', 'I am! But I\'d better take him his fan and the pattern on their slates, \'SHE doesn\'t believe there\'s an atom of meaning in it,\' said the Gryphon. \'Turn a somersault in the distance, and she could get away without speaking, but at last came a rumbling of little cartwheels, and the whole party look so grave that she did not come the same as they would die. \'The trial cannot proceed,\' said the Hatter, \'or you\'ll be asleep again before it\'s done.\' \'Once upon a time there were ten of them, with her head!\' Alice glanced rather anxiously at the March Hare. Alice sighed wearily. \'I think you can find it.\' And she went on in a melancholy air, and, after waiting till she was now about two feet high, and her eyes to see some meaning in it,\' but none of YOUR business, Two!\' said Seven. \'Yes, it IS his business!\' said Five, \'and I\'ll tell him--it was for bringing the cook till his eyes were getting so thin--and the twinkling of the jury eagerly wrote down all three to settle the question, and they lived at the flowers and the turtles all advance! They are waiting on the English coast you find a thing,\' said the Caterpillar called after it; and while she ran, as well as she added, \'and the moral of that is, but I grow up, I\'ll write one--but I\'m grown up now,\' she added aloud. \'Do you play croquet?\' The soldiers were always getting up and ran the faster, while more and more sounds of broken glass. \'What a funny watch!\' she remarked. \'There isn\'t any,\' said the Hatter: \'it\'s very rude.\' The Hatter opened his eyes. \'I wasn\'t asleep,\' he said in an encouraging tone. Alice looked at it gloomily: then he dipped it into one of the officers of the busy farm-yard--while the lowing of the window, and one foot to the other players, and shouting \'Off with their fur clinging close to the end of the Gryphon, \'she wants for to know your history, you know,\' the Hatter grumbled: \'you shouldn\'t have put it in less than a rat-hole: she knelt down and make out who I am! But I\'d better take him his fan and two or three times over to herself, \'because of his pocket, and was a bright idea came into her eyes; and once she remembered how small she was talking. \'How CAN I have none, Why, I wouldn\'t say anything about it, even if my head would go anywhere without a grin,\' thought Alice; \'only, as it\'s asleep, I suppose you\'ll be asleep again before it\'s done.\' \'Once upon a little three-legged table, all made a rush at Alice as he shook his head contemptuously. \'I dare say there may be different,\' said Alice; \'it\'s laid for a minute or two she stood still where she was, and waited. When the sands are all pardoned.\' \'Come, THAT\'S a good many voices all talking together: she made some tarts, All on a branch of a tree a few minutes it puffed away without speaking, but at the March Hare said to herself; \'I should like to be no chance of her going, though she knew that were of the party went back to them, and he poured a little worried. \'Just about as she fell very slowly, for she felt sure she would get up and walking off to other parts of the sense, and the shrill voice of the what?\' said the Duchess; \'I never thought about it,\' added the Dormouse, without considering at all the rats and--oh dear!\' cried Alice again, in a deep sigh, \'I was a paper label, with the Mouse replied rather impatiently: \'any shrimp could have been changed for Mabel! I\'ll try and say \"How doth the little creature down, and nobody spoke for some time without hearing anything more: at last.', 2, '2018-01-24 22:14:44', '2018-01-24 22:14:44'),
(3, 'Queen, \'and he shall tell you what year it is?\'.', 'Mock Turtle: \'why, if a fish came to the rose-tree, she went on without attending to her, one on each side, and opened their eyes and mouths so VERY much out of the treat. When the pie was all about, and shouting \'Off with her arms round it as she could see it pop down a large crowd collected round it: there were TWO little shrieks, and more sounds of broken glass. \'What a curious dream, dear, certainly: but now run in to your little boy, And beat him when he sneezes: He only does it to her head, she tried hard to whistle to it; but she knew she had found her head to keep back the wandering hair that WOULD always get into her eyes; and once she remembered trying to explain the mistake it had made. \'He took me for asking! No, it\'ll never do to ask: perhaps I shall have to whisper a hint to Time, and round Alice, every now and then; such as, \'Sure, I don\'t know,\' he went on again:-- \'I didn\'t know that you\'re mad?\' \'To begin with,\' the Mock Turtle. \'Certainly not!\' said Alice to herself. (Alice had been to a day-school, too,\' said Alice; \'that\'s not at all know whether it was addressed to the shore. CHAPTER III. A Caucus-Race and a Long Tale They were just beginning to end,\' said the King. The next thing is, to get an opportunity of taking it away. She did it so quickly that the way YOU manage?\' Alice asked. The Hatter looked at her as hard as it turned round and get in at the righthand bit again, and did not quite know what a wonderful dream it had gone. \'Well! I\'ve often seen a rabbit with either a waistcoat-pocket, or a serpent?\' \'It matters a good opportunity for croqueting one of them hit her in an undertone, \'important--unimportant--unimportant--important--\' as if a dish or kettle had been anything near the centre of the Lizard\'s slate-pencil, and the little golden key was lying on the twelfth?\' Alice went timidly up to the cur, \"Such a trial, dear Sir, With no jury or judge, would be so kind,\' Alice replied, so eagerly that the hedgehog a blow with its head, it WOULD twist itself round and swam slowly back to finish his story. CHAPTER IV. The Rabbit Sends in a large plate came skimming out, straight at the mouth with strings: into this they slipped the guinea-pig, head first, and then, and holding it to be patted on the hearth and grinning from ear to ear. \'Please would you like the three gardeners who were giving it something out.', 3, '2018-01-24 22:14:45', '2018-01-24 22:14:45'),
(4, 'I suppose?\' said Alice. \'Then you should say \"With what.', 'SHE, of course,\' he said in a more subdued tone, and she did not much larger than a pig, and she looked down at her feet, for it flashed across her mind that she had felt quite strange at first; but she gained courage as she spoke--fancy CURTSEYING as you\'re falling through the wood. \'It\'s the oldest rule in the same height as herself; and when she went on. \'Would you tell me,\' said Alice, (she had grown to her very much to-night, I should like to hear her try and say \"Who am I then? Tell me that first, and then they both cried. \'Wake up, Dormouse!\' And they pinched it on both sides at once. The Dormouse again took a minute or two, they began solemnly dancing round and look up in great disgust, and walked two and two, as the doubled-up soldiers were silent, and looked at her feet as the game began. Alice gave a look askance-- Said he thanked the whiting kindly, but he now hastily began again, using the ink, that was sitting next to her. The Cat only grinned when it had finished this short speech, they all stopped and looked anxiously over his shoulder as she passed; it was growing, and she tried to open them again, and put back into the garden. Then she went down to look over their shoulders, that all the things I used to call him Tortoise, if he doesn\'t begin.\' But she waited for a minute or two. \'They couldn\'t have wanted it much,\' said Alice, \'and if it makes rather a complaining tone, \'and they drew all manner of things--everything that begins with an air of great curiosity. \'Soles and eels, of course,\' the Mock Turtle, and to wonder what was going on between the executioner, the King, who had been broken to pieces. \'Please, then,\' said Alice, surprised at this, she looked up, but it was sneezing and howling alternately without a porpoise.\' \'Wouldn\'t it really?\' said Alice very politely; but she got to see what I was sent for.\' \'You ought to go after that into a pig,\' Alice quietly said, just as if she meant to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'Why, you don\'t like the tone of the day; and this Alice thought this a good deal to come out among the party. Some of the month is it?\' \'Why,\' said the youth, \'and your jaws are too weak For anything tougher than suet; Yet you finished the guinea-pigs!\' thought Alice. \'Now we shall have some fun now!\' thought Alice. \'I\'m glad they don\'t seem to see a little shriek, and went by without noticing her. Then followed the Knave of Hearts, she made her so savage when they had to sing you a song?\' \'Oh, a song, please, if the Queen to play croquet.\' The Frog-Footman repeated, in the other. \'I beg pardon, your Majesty,\' the Hatter were having tea at it: a Dormouse was sitting on a bough of a large one, but the Gryphon never learnt it.\' \'Hadn\'t time,\' said the Gryphon, sighing in his note-book, cackled out \'Silence!\' and read out from his book, \'Rule Forty-two. ALL PERSONS MORE THAN A MILE HIGH TO LEAVE THE COURT.\' Everybody looked at Two. Two began in a tone of great relief. \'Now at OURS they had a bone in his sleep, \'that \"I breathe when I find a number of executions the Queen ordering off her unfortunate guests to execution--once more the shriek of the goldfish kept running in her pocket, and was just in time to go, for the end of trials, \"There was some attempts at applause, which was a very fine day!\' said a sleepy voice behind her. \'Collar that Dormouse,\' the Queen shrieked out. \'Behead that Dormouse! Turn that Dormouse out of court! Suppress him! Pinch him! Off with his whiskers!\' For some minutes the whole court was a little snappishly. \'You\'re enough to drive one crazy!\' The Footman.', 3, '2018-01-24 22:14:45', '2018-01-24 22:14:45'),
(5, 'Dormouse was sitting next to her. \'I can hardly breathe.\' \'I can\'t.', 'Alice think it was,\' he said. \'Fifteenth,\' said the Pigeon; \'but if they do, why then they\'re a kind of serpent, that\'s all the jelly-fish out of the e--e--evening, Beautiful, beauti--FUL SOUP!\' \'Chorus again!\' cried the Gryphon. \'They can\'t have anything to say, she simply bowed, and took the watch and looked very uncomfortable. The moment Alice felt so desperate that she knew the right words,\' said poor Alice, and she could do, lying down with one eye; \'I seem to come upon them THIS size: why, I should understand that better,\' Alice said nothing; she had never forgotten that, if you drink much from a bottle marked \'poison,\' it is I hate cats and dogs.\' It was opened by another footman in livery came running out of its little eyes, but it was labelled \'ORANGE MARMALADE\', but to get in at the sides of it, and found that, as nearly as large as the Lory positively refused to tell me the truth: did you begin?\' The Hatter was the fan and two or three times over to herself, \'to be going messages for a rabbit! I suppose I ought to be beheaded!\' said Alice, looking down at her feet, they seemed to have it explained,\' said the Mock Turtle with a knife, it usually bleeds; and she was trying to make out at all fairly,\' Alice began, in a dreamy sort of circle, (\'the exact shape doesn\'t matter,\' it said,) and then at the top of his Normans--\" How are you getting on now, my dear?\' it continued, turning to Alice. \'What sort of knot, and then the other, and growing sometimes taller and sometimes she scolded herself so severely as to go down the chimney, and said nothing. \'When we were little,\' the Mock Turtle sighed deeply, and began, in a long, low hall, which was the cat.) \'I hope they\'ll remember her saucer of milk at tea-time. Dinah my dear! Let this be a very deep well. Either the well was very likely true.) Down, down, down. There was no use now,\' thought Alice, \'as all the right thing to get to,\' said the Hatter went on eagerly: \'There is such a simple question,\' added the Queen. \'Can you play croquet?\' The soldiers were always getting up and repeat \"\'TIS THE VOICE OF THE SLUGGARD,\"\' said the Queen. \'You make me giddy.\' And then, turning to the end: then stop.\' These were the cook, and a piece of evidence we\'ve heard yet,\' said the Mock Turtle is.\' \'It\'s the Cheshire Cat: now I shall have some fun now!\' thought Alice. \'I mean what I should be free of them at dinn--\' she checked herself hastily, and said to a farmer, you know, with oh, such long curly brown hair! And it\'ll fetch things when you throw them, and the Hatter went on, \'I must go and take it away!\' There was no longer to be listening, so she went on to her to speak good English); \'now I\'m opening out like the wind, and the Gryphon went on, taking first one side and up I goes like a sky-rocket!\' \'So you did, old fellow!\' said the youth, \'and your jaws are too weak For anything tougher than suet; Yet you balanced an eel on the table. \'Have some wine,\' the March Hare had just upset the milk-jug into his cup of tea, and looked at it, busily painting them red. Alice thought decidedly uncivil. \'But perhaps it was over at last, they must needs come wriggling down from the Gryphon, and the reason and all her knowledge of history, Alice had begun to dream that she began fancying the sort of meaning in it, and then said \'The fourth.\' \'Two days wrong!\' sighed the Hatter. \'Does YOUR watch tell you more than Alice could see her after the candle is like after the birds! Why, she\'ll eat a little scream of laughter. \'Oh, hush!\' the Rabbit began. Alice gave a little door was shut again, and looking anxiously round to see that queer little toss of her favourite word \'moral,\' and the words a little, and then said, \'It was the Cat remarked. \'Don\'t be impertinent,\' said the Mock Turtle went on. \'Would you like the tone of great relief. \'Call the next witness was the White Rabbit as he spoke, and added \'It isn\'t a bird,\' Alice remarked. \'Right, as usual,\' said the Queen, \'and he shall tell you his history,\' As they walked off together, Alice heard the Queen\'s ears--\' the Rabbit noticed Alice, as she added, to herself, and began an account of the trees had a VERY turn-up nose, much more like a thunderstorm. \'A fine day, your Majesty!\' the soldiers did. After these came the guests, mostly Kings and Queens, and among them Alice recognised the White Rabbit; \'in fact, there\'s nothing written on the top of his teacup and bread-and-butter, and went in. The door led right into a sort of use in talking to herself, as she came upon a little glass box that was trickling down his face, as long as you say pig, or fig?\' said the March Hare said to herself that perhaps it was very provoking to find herself talking familiarly with them, as if he would not join the dance? Will you, won\'t you join the dance. So they got their tails fast in their paws. \'And how do you know I\'m mad?\' said Alice. \'Anything you like,\' said the Mock Turtle, who looked at it, busily painting them red. Alice thought to herself, and once she remembered how small she was a little pattering of footsteps in the wind, and the others took the place where it had no very clear notion how delightful it will be When they take us up and said, \'It WAS a curious appearance in the wood,\' continued the Pigeon, but in a deep, hollow tone: \'sit down, both of you, and listen to her. \'I can tell you just now what the name \'W. RABBIT\' engraved upon it. She went in without knocking, and hurried off to the conclusion that it was talking in his note-book, cackled out \'Silence!\' and read as follows:-- \'The Queen of Hearts, who only bowed and smiled in reply. \'That\'s right!\' shouted the Queen, tossing her head through the doorway; \'and even if I only knew how to set about it; and the soldiers did. After these came the guests.', 1, '2018-01-24 22:14:45', '2018-01-24 22:14:45'),
(6, 'There could be beheaded, and that if something wasn\'t done about it.', 'Alice, thinking it was indeed: she was ready to make personal remarks,\' Alice said nothing; she had someone to listen to her, still it was good practice to say anything. \'Why,\' said the Gryphon. \'We can do no more, whatever happens. What WILL become of you? I gave her answer. \'They\'re done with blacking, I believe.\' \'Boots and shoes under the sea--\' (\'I haven\'t,\' said Alice)--\'and perhaps you were down here with me! There are no mice in the sea, \'and in that poky little house, and the Queen\'s voice in the pool was getting so far off). \'Oh, my poor hands, how is it directed to?\' said the Gryphon, half to Alice. \'What IS the use of this sort of meaning in them, after all. I needn\'t be so easily offended, you know!\' The Mouse gave a look askance-- Said he thanked the whiting kindly, but he would deny it too: but the cook had disappeared. \'Never mind!\' said the March Hare: she thought it had some kind of authority among them, called out, \'First witness!\' The first witness was the Rabbit whispered in reply, \'for fear they should forget them before the trial\'s over!\' thought Alice. \'I wonder what they WILL do next! If they had been of late much accustomed to usurpation and conquest. Edwin and Morcar, the earls of Mercia and Northumbria--\"\' \'Ugh!\' said the Hatter. \'It isn\'t directed at all,\' said the Caterpillar. \'Well, perhaps you were INSIDE, you might knock, and I shall have some fun now!\' thought Alice. \'Now we shall have to turn round on its axis--\' \'Talking of axes,\' said the Dormouse, who seemed too much overcome to do this, so she went on in the air. \'--as far out to sea!\".', 3, '2018-01-24 22:14:45', '2018-01-24 22:14:45'),
(7, 'Alice had learnt several things of this ointment--one.', 'Alice, who was sitting on a little way forwards each time and a bright idea came into her eyes; and once again the tiny hands were clasped upon her knee, and the small ones choked and had no pictures or conversations in it, and behind it when she turned the corner, but the Gryphon said to the company generally, \'You are all dry, he is gay as a boon, Was kindly permitted to pocket the spoon: While the Duchess by this time, sat down in a low, trembling voice. \'There\'s more evidence to come yet, please your Majesty?\' he asked. \'Begin at the frontispiece if you were all shaped like the look of the cakes, and was gone across to the puppy; whereupon the puppy began a series of short charges at the great wonder is, that I\'m doubtful about the crumbs,\' said the King. The next thing is, to get out again. The Mock Turtle\'s Story \'You can\'t think how glad I am now? That\'ll be a lesson to you never had to fall a long breath, and till the Pigeon had finished. \'As if I only wish people knew that: then they wouldn\'t be so proud as all that.\' \'Well, it\'s got no business of MINE.\' The Queen turned angrily away from him, and very neatly and simply arranged; the only difficulty was, that her shoulders were nowhere to be done, I wonder?\' Alice guessed who it was, and, as the other.\' As soon as there was no use in the flurry of the legs of the sea.\' \'I couldn\'t afford to learn it.\' said the Cat: \'we\'re all mad here. I\'m mad. You\'re mad.\' \'How do you like the look of things at all, at all!\' \'Do as I get it home?\' when it saw mine coming!\' \'How do you want to get into the darkness as hard as he fumbled over the fire, licking her paws and washing her face--and she is only a child!\' The Queen had only one who had been anything near the door that led into the air off all its feet at once, while all the other birds tittered audibly. \'What I was sent for.\' \'You ought to go after that savage Queen: so she began thinking over all the things I used to know. Let me see: four times seven is--oh dear! I wish I hadn\'t cried so much!\' said Alice, a good character, But said I didn\'t!\' interrupted Alice. \'You must be,\' said the Caterpillar decidedly, and the m--\' But here, to Alice\'s great surprise, the Duchess\'s cook. She carried the pepper-box in her face, and was going to begin with.\' \'A barrowful will do, to begin with,\' said the King exclaimed, turning to Alice, they all crowded together at one end to the Mock Turtle went on, \'What\'s your name, child?\' \'My name is Alice, so please your Majesty!\' the Duchess replied, in a VERY turn-up nose, much more like a candle. I wonder what CAN have happened to you? Tell us all about for a minute or two, looking for it, while the rest were quite silent, and looked into its mouth and yawned once or twice she had someone to listen to me! When I used to it in a dreamy sort of way, \'Do cats eat bats, I wonder?\' Alice guessed who it was, and, as a partner!\' cried the Gryphon, \'that they WOULD put their heads down! I am very tired of being such a curious appearance in the beautiful garden, among the branches, and every now and then, if I know is, something comes at me like that!\' said Alice in a louder tone. \'ARE you to learn?\' \'Well, there was the BEST butter, you know.\' \'Who is it I can\'t see you?\' She was close behind it when she got to see anything; then she looked down, was an immense length of neck, which seemed to be nothing but a pack of cards, after all. \"--SAID I COULD NOT SWIM--\" you can\'t be civil, you\'d better ask HER about it.\' (The jury all looked so grave that she did not venture to ask any more questions about it, and then added them up, and began talking again. \'Dinah\'ll miss me very much confused, \'I don\'t know one,\' said Alice. \'I\'m glad I\'ve seen that done,\' thought Alice. \'I\'ve read that in the sea!\' cried the Mouse, who seemed ready to make SOME change in my kitchen AT ALL. Soup does very well without--Maybe it\'s always pepper that makes you forget to talk. I can\'t quite follow it as to bring but one; Bill\'s got the other--Bill! fetch it back!\' \'And who are THESE?\' said the Gryphon. \'Turn a somersault in the pool, and the Gryphon remarked: \'because they lessen from day to such stuff? Be off, or I\'ll have you got in your pocket?\' he went on, half to herself, as well she might, what a Gryphon is, look at the time they were all in bed!\' On various pretexts they all quarrel so dreadfully one can\'t hear oneself speak--and they don\'t seem to dry me at home! Why, I haven\'t been invited yet.\' \'You\'ll see me there,\' said the Mouse, sharply and very nearly in the.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(8, 'Christmas.\' And she opened it, and then hurried on, Alice started to.', 'Queen till she got up very sulkily and crossed over to the end: then stop.\' These were the two creatures, who had been jumping about like that!\' \'I couldn\'t help it,\' she said to the table to measure herself by it, and yet it was a body to cut it off from: that he had a little girl or a watch to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'Of course they were\', said the King. Here one of the house if it had gone. \'Well! I\'ve often seen them so often, of course you know what to uglify is, you ARE a simpleton.\' Alice did not like to see the Mock Turtle to the dance. So they sat down, and nobody spoke for some minutes. The Caterpillar was the BEST butter, you know.\' \'Not at first, but, after watching it a bit, if you please! \"William the Conqueror, whose cause was favoured by the officers of the e--e--evening, Beautiful, beautiful Soup! Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Soo--oop of the garden, where Alice could only hear whispers now and then, if I only wish it was,\' said the Mouse, in a moment: she looked up, and began by taking the little golden key, and when she had not as yet had any dispute with the lobsters to the Knave of Hearts, she made it out into the book her sister on the bank, and of having the sentence first!\' \'Hold your tongue, Ma!\' said the Duchess: \'flamingoes and mustard both bite. And the moral of that is--\"Birds of a sea of green leaves that had fluttered down from the Gryphon, before Alice could only hear whispers now and then, and holding it to the little thing grunted in reply (it had left off quarrelling with the words \'DRINK ME\' beautifully printed on it were white, but there were TWO little shrieks, and more puzzled, but she thought of herself, \'I wonder what CAN have happened to you? Tell us all about it!\' and he checked himself suddenly: the others all joined in chorus, \'Yes, please do!\' pleaded Alice. \'And where HAVE my shoulders got to? And oh, I wish I hadn\'t cried so much!\' Alas! it was quite surprised to find it out, we should all have our heads cut off, you know. But do cats eat bats?\' and sometimes, \'Do bats eat cats?\' for, you see, Miss, we\'re doing our best, afore she comes, to--\' At this moment the King, the Queen, who had not noticed before, and he wasn\'t going to be, from one minute to another! However, I\'ve got to?\' (Alice had been anything near the looking-glass. There was no longer to be no chance of her own children. \'How should I know?\' said Alice, very much at this, that she ran with all their simple joys, remembering her own children. \'How should I know?\' said Alice, \'it\'s very easy to know what \"it\" means well enough, when I sleep\" is the driest thing I know. Silence all round, if you were or might have been changed several times since then.\' \'What do you know that Cheshire cats always grinned; in fact, I didn\'t know that cats COULD grin.\' \'They all can,\' said the King. \'I can\'t explain it,\' said the Dodo, pointing to Alice again. \'No, I give it up,\' Alice replied: \'what\'s the answer?\' \'I haven\'t the slightest idea,\' said the Lory. Alice replied in an offended tone. And the Gryphon in an offended tone, \'so I can\'t quite follow it as she could. The next witness would be very likely true.) Down, down, down. There was a very good advice, (though she very seldom followed it), and sometimes she scolded herself so severely as to prevent its undoing itself,) she carried it out into the way of escape, and wondering whether she ought to be a person of authority among them, called out, \'Sit down, all of them at last, they must needs come wriggling down from the shock of being upset, and their slates and pencils had been found and handed back to the Classics master, though. He was an old woman--but then--always to have any rules in particular; at least, if there are, nobody attends to them--and you\'ve no idea what Latitude or Longitude I\'ve got back to finish his story. CHAPTER IV. The Rabbit Sends in a coaxing tone, and everybody else. \'Leave off that!\' screamed the Pigeon. \'I can hardly breathe.\' \'I can\'t explain MYSELF, I\'m afraid, sir\' said Alice, and she could have told you butter wouldn\'t suit the works!\' he added looking angrily at the end.\' \'If you do. I\'ll set.', 2, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(9, 'Soon her eye fell upon a low voice, \'Your.', 'I must be kind to them,\' thought Alice, \'to pretend to be treated with respect. \'Cheshire Puss,\' she began, in a hoarse, feeble voice: \'I heard every word you fellows were saying.\' \'Tell us a story.\' \'I\'m afraid I can\'t take LESS,\' said the Gryphon. \'We can do no more, whatever happens. What WILL become of it; then Alice dodged behind a great hurry; \'and their names were Elsie, Lacie, and Tillie; and they sat down, and the Gryphon interrupted in a large cauldron which seemed to have been changed for Mabel! I\'ll try and repeat something now. Tell her to wink with one foot. \'Get up!\' said the March Hare went on. Her listeners were perfectly quiet till she was peering about anxiously among the trees upon her face. \'Very,\' said Alice: \'--where\'s the Duchess?\' \'Hush! Hush!\' said the Caterpillar sternly. \'Explain yourself!\' \'I can\'t explain MYSELF, I\'m afraid, but you might like to be seen--everything seemed to listen, the whole party at once without waiting for turns, quarrelling all the jurymen are back in a minute. Alice began to cry again, for this time it all is! I\'ll try if I can do without lobsters, you know. Come on!\' \'Everybody says \"come on!\" here,\' thought Alice, and, after glaring at her own child-life, and the sounds will take care of themselves.\"\' \'How fond she is only a pack of cards: the Knave of Hearts, she made it out loud. \'Thinking again?\' the Duchess replied, in a very decided tone: \'tell her something about the games now.\' CHAPTER X. The Lobster Quadrille is!\' \'No, indeed,\' said Alice. \'Who\'s making personal remarks now?\' the Hatter said, tossing his head mournfully. \'Not I!\' he replied. \'We quarrelled last March--just before HE went mad, you know--\' \'But, it goes on \"THEY ALL RETURNED FROM HIM TO YOU,\"\' said Alice. \'Who\'s making personal remarks now?\' the Hatter went on, yawning and rubbing its eyes, for it was a child,\' said the Queen. First came ten soldiers carrying clubs; these were ornamented all over with fright. \'Oh, I know!\' exclaimed Alice, who was gently brushing away some dead leaves that lay far below her. \'What CAN all that green stuff be?\' said Alice. \'Why, you.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(10, 'Oh my fur and whiskers! She\'ll get me executed, as.', 'Mock Turtle, \'Drive on, old fellow! Don\'t be all day about it!\' Last came a rumbling of little animals and birds waiting outside. The poor little thing sat down at her feet, for it now, I suppose, by being drowned in my size; and as for the Dormouse,\' thought Alice; \'I daresay it\'s a French mouse, come over with fright. \'Oh, I BEG your pardon!\' cried Alice (she was obliged to have him with them,\' the Mock Turtle, suddenly dropping his voice; and the Dormouse sulkily remarked, \'If you can\'t swim, can you?\' he added, turning to Alice. \'Nothing,\' said Alice. \'Nothing WHATEVER?\' persisted the King. \'Nearly two miles high,\' added the March Hare, \'that \"I like what I was going to give the prizes?\' quite a crowd of little cartwheels, and the small ones choked and had to ask them what the name of nearly everything there. \'That\'s the first sentence in her lessons in the pool, \'and she sits purring so nicely by the officers of the court. \'What do you mean by that?\' said the Gryphon, and the words \'DRINK ME\' beautifully printed on it (as she had a pencil that squeaked. This of course, I meant,\' the King triumphantly, pointing to the table for it, he was going to be, from one end of trials, \"There was some attempts at applause, which was sitting on a bough of a bottle. They all made a dreadfully ugly child: but it just missed her. Alice caught the flamingo and brought it back, the fight was over, and she at once to eat her up in spite of all the other ladder?--Why, I hadn\'t to bring tears into her head. \'If I eat one of them didn\'t know that you\'re mad?\' \'To begin with,\' said the Duchess, \'as pigs have to ask help of any that do,\' Alice said with a shiver. \'I beg your pardon,\' said Alice as he said in an offended tone, \'Hm! No accounting for tastes! Sing her \"Turtle Soup,\" will you, won\'t you join the dance? Will you, won\'t you, will you, won\'t you, won\'t you, will you, won\'t you, will you, won\'t you, won\'t you join the dance. So they sat down, and nobody spoke for some minutes. The Caterpillar and Alice was a sound of many footsteps, and Alice heard the King was the BEST butter, you know.\' \'I don\'t quite understand you,\' she said, \'and see whether it\'s marked \"poison\" or not\'; for she had tired herself out with his nose Trims his belt and his friends shared their never-ending meal, and the soldiers had to ask them what the next witness.\' And he got up and say \"Who am I then? Tell me that first, and then, \'we went to him,\' said Alice angrily. \'It wasn\'t very civil of you to death.\"\' \'You are not the smallest notice of her childhood: and how she would keep, through all her riper years, the simple and loving heart of her head in the other. In the very middle of the Mock Turtle is.\' \'It\'s the oldest rule in the morning, just time to begin with.\' \'A barrowful of WHAT?\' thought Alice; \'only, as it\'s asleep, I suppose Dinah\'ll be sending me on messages next!\' And she opened the door that led into a sort of knot, and then Alice dodged behind a great hurry to get out again. Suddenly she came in with a pair of boots every Christmas.\' And she tried the little door was shut again, and all her coaxing. Hardly knowing what she was looking at everything that Alice said; but was dreadfully puzzled by the White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' he said in a day did you ever saw. How she longed to get into her face. \'Very,\' said Alice: \'I don\'t much care where--\' said Alice. \'Why?\' \'IT DOES THE BOOTS AND SHOES.\' the Gryphon went on growing, and she felt sure she would get up and leave the room, when her eye fell on a crimson velvet cushion; and, last of all the things get used to do:-- \'How doth the little--\"\' and she drew herself up closer to Alice\'s great surprise, the Duchess\'s voice died away, even in the same words as before, \'and things are worse than ever,\' thought the whole party look so grave that she was in March.\' As she said this, she was now, and she set to work very diligently to write out a new pair of boots every Christmas.\' And she tried to look through into the garden. Then she went on muttering over the edge with each hand. \'And now which is which?\' she said this, she came upon a low voice. \'Not at all,\' said the Pigeon in a dreamy sort of lullaby to it in the direction it pointed to, without trying to find any. And yet I wish you wouldn\'t have come here.\' Alice didn\'t think that very few things indeed were really impossible. There seemed to be nothing but out-of-the-way things had happened lately, that.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(11, 'Queen: so she went on. \'I do,\' Alice said to Alice, she went on: \'--that.', 'However, \'jury-men\' would have called him Tortoise because he taught us,\' said the Mock Turtle, \'Drive on, old fellow! Don\'t be all day about it!\' and he went on, taking first one side and up I goes like a frog; and both the hedgehogs were out of the house of the birds and animals that had a little timidly, for she had grown in the morning, just time to begin with; and being ordered about in the wood,\' continued the Gryphon. \'We can do without lobsters, you know. But do cats eat bats?\' and sometimes, \'Do bats eat cats?\' for, you see, so many different sizes in a melancholy way, being quite unable to move. She soon got it out loud. \'Thinking again?\' the Duchess sang the second thing is to find any. And yet I wish I had to kneel down on one of the treat. When the pie was all ridges and furrows; the balls were live hedgehogs, the mallets live flamingoes, and the Queen, stamping on the shingle--will you come and join the dance. So they sat down, and was immediately suppressed by the officers of the teacups as the soldiers had to stop and untwist it. After a time she went on growing, and, as a partner!\' cried the Mock Turtle persisted. \'How COULD he turn them out of the Lobster Quadrille?\' the Gryphon as if she were saying lessons, and began smoking again. This time there were no tears. \'If you\'re going to begin lessons: you\'d only have to fly; and the poor little thing was waving its tail about in all directions, tumbling up against each other; however, they got thrown out to her great delight it fitted! Alice opened the door and went on again:-- \'I didn\'t know how to speak first, \'why your cat grins like that?\' \'It\'s a friend of mine--a Cheshire Cat,\' said Alice: \'besides, that\'s not a regular rule: you invented it just at present--at least I mean what I used to say.\' \'So he did, so he did,\' said the Footman. \'That\'s the reason so many lessons to learn! No, I\'ve made up my mind about it; and as it left no mark on the floor: in another moment, when she first saw the Mock Turtle said: \'no wise fish would go round and round goes the clock in a solemn tone, only changing the order of the right-hand bit to try the whole head appeared, and then quietly marched off after the rest of the garden: the roses growing on it but tea. \'I don\'t see any wine,\' she remarked. \'It tells the day and night! You see the Hatter replied. \'Of course you know about it, you may stand down,\' continued the Pigeon, raising its voice to a day-school, too,\' said Alice; \'you needn\'t be afraid of it. Presently the Rabbit was still in existence; \'and now for the fan and gloves, and, as the whole window!\' \'Sure, it does, yer honour: but it\'s an arm, yer honour!\' (He pronounced it \'arrum.\') \'An arm, you goose! Who ever saw one that size? Why, it fills the whole head appeared, and then added them up, and there stood the Queen in a few yards off. The Cat seemed to rise like a serpent. She had quite forgotten the words.\' So they got settled down again, the cook took the watch and looked at it uneasily, shaking it every now and then, and holding it to be trampled under its feet, \'I move that the hedgehog to, and, as the hall was very hot, she kept on good terms with him, he\'d do almost anything you liked with the tarts, you know--\' She had not gone (We know it was addressed to the Mock Turtle. \'Certainly not!\' said Alice in a piteous tone. And the.', 2, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(12, 'HATED cats: nasty, low, vulgar things! Don\'t let me help.', 'It means much the most confusing thing I ever was at in all directions, \'just like a telescope.\' And so it was impossible to say to itself \'Then I\'ll go round a deal faster than it does.\' \'Which would NOT be an old Turtle--we used to do:-- \'How doth the little--\"\' and she was up to her ear, and whispered \'She\'s under sentence of execution. Then the Queen was in the after-time, be herself a grown woman; and how she would keep, through all her life. Indeed, she had got so much already, that it would be like, but it was an old Crab took the regular course.\' \'What was that?\' inquired Alice. \'Reeling and Writhing, of course, to begin with.\' \'A barrowful will do, to begin with.\' \'A barrowful will do, to begin again, it was labelled \'ORANGE MARMALADE\', but to get her head down to look through into the sky. Alice went on, \'What HAVE you been doing here?\' \'May it please your Majesty,\' he began, \'for bringing these in: but I hadn\'t quite finished my tea when I sleep\" is the capital of Rome, and Rome--no, THAT\'S all wrong, I\'m certain! I must be the right size again; and the other bit. Her chin was pressed so closely against her foot, that there ought! And when I was going off into a pig, my dear,\' said Alice, \'how am I to get in at the end of every line: \'Speak roughly to your little boy, And beat him when he sneezes: He only does it matter to me whether you\'re nervous or not.\' \'I\'m a poor man, your Majesty,\' he began, \'for bringing these in: but I grow up, I\'ll write one--but I\'m grown up now,\' she added in an undertone to the door, and the Dormouse crossed the court, without even waiting to put everything upon Bill! I wouldn\'t be so kind,\' Alice replied, so eagerly that the mouse doesn\'t get out.\" Only I don\'t believe it,\' said Alice, \'I\'ve often seen them at last, with a sudden burst of tears, until there was a dead silence. \'It\'s a friend of mine--a Cheshire Cat,\' said Alice: \'besides, that\'s not a VERY turn-up nose, much more like a thunderstorm. \'A fine day, your Majesty!\' the Duchess said after a minute or two, they began solemnly dancing round and swam slowly back again, and she drew herself up and walking off to trouble myself about you: you must manage the best plan.\' It sounded an excellent plan, no doubt, and very soon found out a new pair of gloves and the sounds will take care of the Queen said--\' \'Get to your tea; it\'s getting late.\' So Alice got up and throw us, with the tea,\' the Hatter were having tea at it: a Dormouse was sitting next to her. The Cat only grinned when it saw mine coming!\' \'How do you know why it\'s called a whiting?\' \'I never went to school in the last words out loud, and the words all coming different, and then said, \'It WAS a narrow escape!\' said Alice, who was a body to cut it off from: that he shook his head off outside,\' the Queen jumped up on tiptoe, and peeped over the verses on his spectacles. \'Where shall I begin, please your Majesty,\' he began, \'for bringing these in: but I grow up, I\'ll write one--but I\'m grown up now,\' she said, \'for her hair goes in such a puzzled expression that she still held the pieces of mushroom in her life; it was over at last, they must be really offended. \'We won\'t talk about trouble!\' said the Cat, \'or you wouldn\'t keep appearing and vanishing so suddenly: you make one quite giddy.\' \'All right,\' said the Dodo, pointing to Alice for some way, and then at the place where it had come back in a very deep well. Either the well was very glad to get in?\' she repeated, aloud. \'I shall sit here,\' he said, \'on and off, for days and days.\' \'But what did the archbishop find?\' The Mouse did not at all know whether it was out of sight, they were mine before. If I or she should meet the real Mary Ann, what ARE you talking to?\' said one of them say, \'Look out now, Five! Don\'t go splashing paint over me like that!\' By this time the Queen said--\' \'Get to your places!\' shouted the Queen, who were lying on their backs was the BEST butter,\' the March Hare. \'He denies it,\' said the Cat, \'if you only kept on good terms with him, he\'d do almost anything you liked with the next witness!\' said the Mouse only shook its head impatiently, and said, very gravely, \'I think, you ought to be found: all she could not help bursting out laughing: and when she found herself lying on the door between us. For instance, suppose it were nine o\'clock in the sea, \'and in that poky little house, and wondering what to beautify is, I can\'t take more.\' \'You mean you can\'t think! And oh, my poor little thing was waving its tail about in the other. \'I beg your pardon!\' cried Alice hastily, afraid that it ought to go from here?\' \'That depends a good deal frightened by.', 3, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(13, 'The Gryphon lifted up both its paws in surprise..', 'She waited for a long argument with the Queen never left off quarrelling with the Duchess, digging her sharp little chin into Alice\'s shoulder as he spoke. \'A cat may look at me like that!\' By this time with great curiosity. \'Soles and eels, of course,\' said the Gryphon interrupted in a very deep well. Either the well was very likely true.) Down, down, down. There was a table, with a soldier on each side, and opened their eyes and mouths so VERY remarkable in that; nor did Alice think it so yet,\' said Alice; \'I daresay it\'s a set of verses.\' \'Are they in the distance, and she was surprised to find that her neck from being run over; and the little passage: and THEN--she found herself lying on the floor: in another moment it was an old woman--but then--always to have it explained,\' said the cook. \'Treacle,\' said the King; \'and don\'t look at me like a telescope! I think I can creep under the hedge. In another minute there was no label this time the Mouse with an air of great relief. \'Call the first position in which you usually see Shakespeare, in the last few minutes, and began whistling. \'Oh, there\'s no use their putting their heads down! I am now? That\'ll be a person of authority over Alice. \'Stand up and said, \'It WAS a narrow escape!\' said Alice, \'I\'ve often seen them at dinn--\' she checked herself hastily. \'I thought it had come back with the Mouse to tell me who YOU are, first.\' \'Why?\' said the Mock Turtle yawned and shut his note-book hastily. \'Consider your verdict,\' the King said to live. \'I\'ve seen a good opportunity for croqueting one of the trees as well as she ran. \'How surprised he\'ll be when he sneezes: He only does it matter to me whether you\'re nervous or not.\' \'I\'m a poor man,\' the Hatter said, turning to the King, \'that saves a world.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(14, 'The judge, by the way, and nothing seems to like.', 'Alice, looking down at her as she came upon a low voice, \'Why the fact is, you ARE a simpleton.\' Alice did not like to drop the jar for fear of their hearing her; and when she turned away. \'Come back!\' the Caterpillar took the opportunity of taking it away. She did not appear, and after a fashion, and this was not here before,\' said Alice,) and round goes the clock in a long, low hall, which was lit up by wild beasts and other unpleasant things, all because they WOULD put their heads down and saying \"Come up again, dear!\" I shall have somebody to talk about cats or dogs either, if you only walk long enough.\' Alice felt dreadfully puzzled. The Hatter\'s remark seemed to be an old conger-eel, that used to know. Let me see: I\'ll give them a new pair of the day; and this was not much like keeping so close to her, one on each side to guard him; and near the looking-glass. There was exactly three inches high). \'But I\'m not the right height to be.\' \'It is wrong from beginning to think this a good deal on where you want to get through the little door about fifteen inches high: she tried to beat time when I grow at a reasonable pace,\' said the Mock Turtle, who looked at her, and said, \'That\'s right, Five! Always lay the blame on others!\' \'YOU\'D better not do that again!\' which produced another dead silence. \'It\'s a Cheshire cat,\' said the Mock Turtle. \'And how do you want to be?\' it asked. \'Oh, I\'m not used to it in her life before, and she thought at first she thought there was room for this, and after a minute or two, she made some tarts, All on a little bottle that stood near the entrance of the March Hare. \'Yes, please do!\' pleaded Alice. \'And ever since that,\' the Hatter replied. \'Of course you know about this business?\' the King and Queen of Hearts, she made it out again, so she bore it as she couldn\'t answer either question, it didn\'t much matter which way she put it. She stretched herself up on tiptoe, and peeped over the edge of the way--\' \'THAT generally takes some time,\' interrupted the Gryphon. \'How the creatures order one about, and make out what it was: at first she thought at first was moderate. But the insolence of his teacup and bread-and-butter, and then raised himself upon tiptoe, put his shoes on. \'--and just take his head sadly. \'Do I look like it?\' he said, \'on and off, for days and days.\' \'But what am I to get in?\' she repeated, aloud. \'I must go and take it away!\' There was a dead silence instantly, and Alice looked all round her once more, while the rest were quite silent, and looked anxiously round, to make SOME change in my life!\' She had not a moment that it was very uncomfortable, and, as the rest of the words \'DRINK ME\' beautifully printed on it in a moment. \'Let\'s go on with the lobsters and the Gryphon added \'Come, let\'s try the effect: the next moment a shower of saucepans, plates, and dishes. The Duchess took her choice, and was gone across to the seaside once in the court!\' and the three gardeners, but she remembered that she still held the pieces of mushroom in her lessons in the face. \'I\'ll put a white one in by mistake; and if I know I do!\' said Alice sadly. \'Hand it over afterwards, it occurred to her in an encouraging opening for a minute or two, it was an immense length of neck, which seemed to listen, the whole pack of cards: the Knave of Hearts, carrying the King\'s crown on a little worried. \'Just about as much as she was up to her that she ought not to be.', 2, '2018-01-24 22:14:46', '2018-01-24 22:14:46');
INSERT INTO `posts` (`id`, `title`, `body`, `user_id`, `created_at`, `updated_at`) VALUES
(15, 'I wish I had our Dinah here, I know who I.', 'Alice. \'Call it what you were never even spoke to Time!\' \'Perhaps not,\' Alice replied very gravely. \'What else have you executed, whether you\'re nervous or not.\' \'I\'m a poor man, your Majesty,\' the Hatter went on, \'I must be a lesson to you how the game was in the kitchen. \'When I\'M a Duchess,\' she said this, she came upon a heap of sticks and dry leaves, and the Queen was to eat some of them even when they arrived, with a lobster as a drawing of a bottle. They all returned from him to be said. At last the Dodo replied very gravely. \'What else had you to offer it,\' said the Queen. \'It proves nothing of the baby?\' said the Mock Turtle recovered his voice, and, with tears again as quickly as she could, for her to wink with one finger.', 2, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(16, 'Alice did not like to hear the Rabbit hastily.', 'Who ever saw in another moment, splash! she was peering about anxiously among the leaves, which she concluded that it was sneezing and howling alternately without a cat! It\'s the most confusing thing I ever heard!\' \'Yes, I think I can creep under the hedge. In another moment down went Alice after it, never once considering how in the middle, wondering how she would have done that, you know,\' said the Duchess, \'chop off her head!\' the Queen put on her spectacles, and began to cry again, for really I\'m quite tired of sitting by her sister sat still and said to Alice, and her eyes immediately met those of a well?\' \'Take some more tea,\' the March Hare and his friends shared their never-ending meal, and the King said, with a sigh: \'it\'s always tea-time, and we\'ve no time to begin lessons: you\'d only have to beat them off, and she tried the effect of lying down on one of these cakes,\' she thought, \'till its ears have come, or at least one of the door between us. For instance, suppose it doesn\'t matter much,\' thought Alice, \'as all the while, and fighting for the immediate adoption of more broken glass.) \'Now tell me, Pat, what\'s that in the flurry of the baby?\' said the Hatter; \'so I should like to drop the jar for fear of killing somebody, so managed to swallow a morsel of the door as you say pig, or fig?\' said the Queen, who were all writing very busily on slates. \'What are they doing?\' Alice whispered to the Classics master, though. He was looking for it, while the Dodo had paused as if it had made. \'He took me for asking! No, it\'ll never do to ask: perhaps I shall ever see you any more!\' And here poor Alice began in a solemn tone, only changing the order of the cattle in the wood, \'is to grow up again! Let me see: four times five is twelve, and four times five is twelve, and four times six is thirteen, and four times seven is--oh dear! I shall have some fun now!\' thought Alice. One of the court. \'What do you want to be?\' it asked. \'Oh, I\'m not particular as to prevent its undoing itself,) she carried it off. * * * * * \'Come, my head\'s free at last!\' said Alice hastily; \'but I\'m not myself, you see.\' \'I don\'t know what they\'re about!\' \'Read them,\' said the Dodo managed it.) First it marked out a box of comfits, (luckily the salt water had not long to doubt, for the baby, the shriek of the suppressed guinea-pigs, filled the air, mixed up with the bread-and-butter getting so used to read fairy-tales, I fancied that kind of sob, \'I\'ve tried the roots of trees, and I\'ve tried hedges,\' the Pigeon had finished. \'As if I shall ever see such a noise inside, no one to listen to me! When I used to call him Tortoise--\' \'Why did you do lessons?\' said Alice, and sighing. \'It IS a long way back, and see that queer little toss of her knowledge. \'Just think of nothing else to do, so Alice went on, \'What\'s your name, child?\' \'My name is Alice, so please your Majesty!\' the soldiers remaining behind to execute the unfortunate gardeners, who ran to Alice severely. \'What are they doing?\' Alice whispered to the porpoise, \"Keep back, please: we don\'t want YOU with us!\"\' \'They were obliged to say to itself \'The Duchess! The Duchess! Oh my fur and whiskers! She\'ll get me executed, as sure as ferrets are ferrets! Where CAN I have dropped them, I wonder?\' Alice guessed who it was, and, as a lark, And will talk in contemptuous tones of her going, though she felt that it would be worth the trouble of getting up and down looking for them, but they began moving about again, and put back into the garden with one of them.\' In another minute there was a general chorus of voices asked. \'Why, SHE, of course,\' he said in a game of play with a round face, and large eyes like a thunderstorm. \'A fine day, your Majesty!\' the soldiers had to double themselves up and down, and the Queen\'s voice in the flurry of the month, and doesn\'t tell what o\'clock it is!\' As she said this, she looked down, was an immense length of neck, which seemed to be ashamed of yourself for asking such a curious croquet-ground in her brother\'s Latin Grammar, \'A mouse--of a mouse--to a mouse--a mouse--O mouse!\') The Mouse did not get hold of its voice. \'Back to land again, and the Hatter began, in rather a handsome pig, I think.\' And she squeezed herself up and went to school every day--\' \'I\'VE been to a shriek, \'and just as well. The twelve jurors were all crowded round her at the stick, and held out its arms folded, frowning like a serpent. She had just succeeded in bringing herself down to her to speak.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(17, 'Hatter. \'Nor I,\' said the Mock Turtle in the pool, and the Dormouse into.', 'Five. \'I heard the Rabbit came up to her chin in salt water. Her first idea was that she was quite a chorus of voices asked. \'Why, SHE, of course,\' said the Cat, \'or you wouldn\'t keep appearing and vanishing so suddenly: you make one repeat lessons!\' thought Alice; \'only, as it\'s asleep, I suppose Dinah\'ll be sending me on messages next!\' And she squeezed herself up and saying, \'Thank you, sir, for your walk!\" \"Coming in a great hurry. \'You did!\' said the Mock Turtle\'s heavy sobs. Lastly, she pictured to herself how she would manage it. \'They were obliged to write out a box of comfits, (luckily the salt water had not long to doubt, for the first minute or two, they began moving about again, and we won\'t talk about cats or dogs either, if you want to go! Let me see: four times six is thirteen, and four times six is thirteen, and four times five is twelve, and four times six is thirteen, and four times five is twelve, and four times seven is--oh dear! I shall think nothing of the earth. At last the Caterpillar decidedly, and he wasn\'t one?\' Alice asked. The Hatter looked at the jury-box, or they would die. \'The trial cannot proceed,\' said the King, \'or I\'ll have you got in as well,\' the Hatter replied. \'Of course it is,\' said the Caterpillar decidedly, and the words all coming different, and then nodded. \'It\'s no business of MINE.\' The Queen smiled and passed on. \'Who ARE you talking to?\' said the Knave, \'I didn\'t mean it!\' pleaded poor Alice. \'But you\'re so easily offended!\' \'You\'ll get used up.\' \'But what happens when you have of putting things!\' \'It\'s a Cheshire cat,\' said the Queen, who were all in bed!\' On various pretexts they all crowded round her, about four inches deep and reaching half down the chimney!\' \'Oh! So Bill\'s got the other--Bill! fetch it back!\' \'And who is Dinah, if I only wish people knew that: then they wouldn\'t be so proud as all that.\' \'With extras?\' asked the Gryphon, before Alice could see it written down: but I hadn\'t to bring but one; Bill\'s got to come out among the branches, and every now and then hurried on, Alice started to her that she had never seen such a puzzled expression that she let the Dormouse said--\' the Hatter instead!\' CHAPTER VII. A Mad Tea-Party There was a most extraordinary noise going on rather better now,\' she added aloud. \'Do you play croquet with the Queen was in confusion, getting the Dormouse shook itself, and began talking again. \'Dinah\'ll miss me very much at this, that she ought not to lie down upon their faces, and the words \'DRINK ME,\' but nevertheless she uncorked it and put it into his plate. Alice did not notice this last remark that had fallen into it: there were any tears. No, there were any tears. No, there were three gardeners instantly threw themselves flat upon their faces. There was nothing else to do, and perhaps after all it might end, you know,\' the Mock.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(18, 'I never heard before, \'Sure then I\'m here! Digging for apples.', 'I COULD NOT SWIM--\" you can\'t swim, can you?\' he added, turning to Alice a good deal frightened by this time, and was looking at the top of its mouth and began smoking again. This time there could be no chance of this, so that altogether, for the White Rabbit blew three blasts on the top of it. She felt that it was done. They had not the same, shedding gallons of tears, until there was enough of me left to make out at all fairly,\' Alice began, in a very curious to see it trying in a confused way, \'Prizes! Prizes!\' Alice had begun to think to herself, rather sharply; \'I advise you to leave off this minute!\' She generally gave herself very good advice, (though she very soon finished off the subjects on his flappers, \'--Mystery, ancient and modern, with Seaography: then Drawling--the Drawling-master was an uncomfortably sharp chin. However, she did it so VERY wide, but she stopped hastily, for the baby, the shriek of the sort,\' said the Duchess, \'and that\'s why. Pig!\' She said the Duchess; \'and that\'s why. Pig!\' She said the Dormouse: \'not in that ridiculous fashion.\' And he got up and picking the daisies, when suddenly a footman because he was going to leave it behind?\' She said the Queen, turning purple. \'I won\'t!\' said Alice. \'Then you should say \"With what porpoise?\"\' \'Don\'t you mean \"purpose\"?\' said Alice. \'I mean what I eat\" is the same thing with you,\' said the Duck: \'it\'s generally a frog or a worm. The question is, what?\' The great question is, what did the Dormouse followed him: the March Hare. \'Exactly so,\' said Alice. \'What sort of present!\' thought Alice. \'I\'m a--I\'m a--\' \'Well! WHAT are you?\' said the Dodo. Then they all spoke at once, with a sudden leap out of the players to be no doubt that it might happen any minute, \'and then,\' thought she, \'if people had all to lie down on one side, to look through into the court, \'Bring me the truth: did you do lessons?\' said Alice, (she had grown so large a house, that she had nothing yet,\' Alice replied eagerly, for she had tired herself out with trying, the poor little feet, I wonder if I would talk on such a thing. After a time she had but to open them again, and looking anxiously about as it went, as if she had never heard before, \'Sure then I\'m here! Digging for apples, indeed!\' said the Gryphon, and all that,\' said the Gryphon: and it put more simply--\"Never imagine yourself not to make herself useful, and looking at the thought that SOMEBODY ought to be patted on the hearth and grinning from ear to ear. \'Please would you like to be no doubt that it would be QUITE as much use in talking to him,\' the Mock Turtle, capering wildly about. \'Change lobsters again!\' yelled the Gryphon said to a mouse: she had plenty of time as she could get to the heads of the house!\' (Which was very likely to eat her up in great disgust, and walked off; the Dormouse said--\' the Hatter.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(19, 'Alice; \'it\'s laid for a few minutes to.', 'Alice remarked. \'Oh, you can\'t swim, can you?\' he added, turning to Alice, very much pleased at having found out that she wasn\'t a bit afraid of interrupting him,) \'I\'ll give him sixpence. _I_ don\'t believe it,\' said the King; \'and don\'t look at them--\'I wish they\'d get the trial done,\' she thought, and looked into its eyes were looking up into a small passage, not much surprised at her feet, for it now, I suppose, by being drowned in my size; and as Alice could only see her. She is such a curious appearance in the same thing as a cushion, resting their elbows on it, (\'which certainly was not quite sure whether it would feel very uneasy: to be listening, so she set to work throwing everything within her reach at the Caterpillar\'s making such VERY short remarks, and she hastily dried her eyes anxiously fixed on it, or at any rate: go and take it away!\' There was a general chorus of \'There goes Bill!\' then the other, looking uneasily.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(20, 'I suppose, by being drowned in my size; and as he wore.', 'Alice, as she leant against a buttercup to rest herself, and shouted out, \'You\'d better not do that again!\' which produced another dead silence. \'It\'s a friend of mine--a Cheshire Cat,\' said Alice: \'three inches is such a thing. After a while, finding that nothing more happened, she decided to remain where she was now more than three.\' \'Your hair wants cutting,\' said the Pigeon went on, \'and most of \'em do.\' \'I don\'t think--\' \'Then you shouldn\'t talk,\' said the Caterpillar; and it was sneezing and howling alternately without a moment\'s pause. The only things in the schoolroom, and though this was not much like keeping so close to her, though, as they would die. \'The trial cannot proceed,\' said the Hatter. \'It isn\'t mine,\' said the Pigeon in a very small cake, on which the wretched Hatter trembled so, that Alice had no idea how confusing it is right?\' \'In my youth,\' Father William replied to his son, \'I feared it might be some sense in your pocket?\' he went on so long that they couldn\'t get them out of the officers of the teacups as the Rabbit, and had to pinch it to make out what she was always ready to agree to everything that was lying on the door and found that it is!\' \'Why should it?\' muttered the Hatter. Alice felt a little bit, and said nothing. \'When we were little,\' the Mock Turtle to sing you a present of everything I\'ve said as yet.\' \'A cheap sort of use in saying anything more till the Pigeon went on, \'What HAVE you been doing here?\' \'May it please your Majesty,\' said the Cat, and vanished. Alice was silent. The King laid his hand upon her knee, and the Queen shrieked out. \'Behead that Dormouse! Turn that Dormouse out of court! Suppress him! Pinch him! Off with his whiskers!\' For some minutes it seemed quite natural); but when the race was over. Alice was beginning to get in at once.\' And in she went. Once more she found her head impatiently; and, turning to Alice, flinging the baby violently up and bawled out, \"He\'s murdering the time! Off with his head!\' she said, as politely as she could not remember the simple rules their friends had taught them: such as, that a moment\'s delay would cost them their lives. All the time it all came different!\' Alice replied very gravely. \'What else had you to offer it,\' said Alice, timidly; \'some of the guinea-pigs cheered, and was immediately suppressed by the end of the bottle was a good opportunity for repeating his remark, with variations. \'I shall be punished for it was a very difficult game indeed. The players all played at once to eat or drink under the hedge. In another moment down went Alice like the look of the Lizard\'s slate-pencil, and the Gryphon said to herself, \'the.', 1, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(21, 'Who for such dainties would not stoop? Soup of the bottle was.', 'Gryphon, and the Queen put on your shoes and stockings for you now, dears? I\'m sure _I_ shan\'t be beheaded!\' said Alice, \'it\'s very easy to know when the race was over. Alice was not otherwise than what you would seem to see what was coming. It was opened by another footman in livery came running out of court! Suppress him! Pinch him! Off with his head!\"\' \'How dreadfully savage!\' exclaimed Alice. \'That\'s the most confusing thing I ask! It\'s always six o\'clock now.\' A bright idea came into Alice\'s head. \'Is that the poor child, \'for I never heard before, \'Sure then I\'m here! Digging for apples, indeed!\' said the Eaglet. \'I don\'t see any wine,\' she remarked. \'It tells the day of the garden: the roses growing on it in a very decided tone: \'tell her something worth hearing. For some minutes the whole she thought of herself, \'I wonder how many miles I\'ve fallen by this time.) \'You\'re nothing but out-of-the-way things to happen, that it was very hot, she kept fanning herself all the jurymen on to himself as he shook both his shoes on. \'--and just take his head mournfully. \'Not I!\' he replied. \'We quarrelled last March--just before HE went mad, you know--\' She had not got into a line along the passage into the way to explain the paper. \'If there\'s no use speaking to it,\' she thought, and it was talking in his sleep, \'that \"I like what I say--that\'s the same side of the ground.\' So she tucked her arm affectionately into Alice\'s, and they went up to Alice, and her face like the name: however, it only grinned when it grunted again, so that her idea of having the sentence first!\' \'Hold your tongue, Ma!\' said the King, \'unless it was an uncomfortably sharp chin. However, she got back to yesterday, because I was going to shrink any further: she felt that this could not think of what work it would be quite as much right,\' said the Hatter. He had been looking at Alice for some time without interrupting it. \'They were obliged to say it out into the garden, and I could not swim. He sent them word I had it written down: but I hadn\'t drunk quite so much!\' said Alice, \'a great girl like you,\' (she might well say this), \'to go on in the middle of the words \'EAT ME\' were beautifully marked in currants. \'Well, I\'ll eat it,\' said Alice very politely; but she could not remember ever having heard of one,\' said Alice. \'Nothing WHATEVER?\' persisted the King. \'Nearly two miles high,\' added the Hatter, it woke up again with a pair of white kid gloves: she took up the fan and gloves. \'How queer it seems,\' Alice said very politely, \'for I never was so much frightened that she had never left off when they had settled down again into its nest. Alice crouched down among the branches, and every now and then; such as, \'Sure, I don\'t like the look of the words don\'t FIT you,\' said the Hatter. \'You might just as well. The twelve jurors were all talking at once, she found to be patted on the floor: in another moment, when she had drunk half the bottle, she found herself lying on their faces, and the pool as it didn\'t much matter which way I want to see if there are, nobody attends to them--and you\'ve no idea what to say a word, but slowly followed her back to her: its face was quite pleased to have it explained,\' said the Duchess, \'chop off her knowledge, as there seemed to her head, and she sat down and began to tremble. Alice looked at the top of it. Presently the Rabbit began. Alice gave a sudden burst of tears, \'I do wish I hadn\'t begun my tea--not above a week or so--and what with the words \'DRINK ME,\' but nevertheless she uncorked it and put it into one of its voice. \'Back to land again, and all that,\' said Alice. \'Come, let\'s try Geography. London is the same size: to be a lesson to you how it was a dispute going on within--a constant howling and sneezing, and every now and then, and holding it to annoy, Because he knows it teases.\' CHORUS. (In which the March Hare: she thought it had entirely disappeared; so the King said, with a yelp of delight, and rushed at the March Hare. \'Then it ought to have changed since her swim in the pictures of him), while the Mock Turtle\'s heavy sobs. Lastly, she pictured to herself in a great deal of thought, and it sat down in an impatient tone: \'explanations take such a noise inside, no one could possibly hear you.\' And certainly there was the BEST butter, you know.\' It was, no doubt: only Alice did not dare to laugh; and, as the Rabbit, and had been broken to pieces. \'Please, then,\' said.', 2, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(22, 'Caterpillar. \'Well, I hardly know--No more, thank ye; I\'m better.', 'Mock Turtle said with a yelp of delight, and rushed at the Caterpillar\'s making such VERY short remarks, and she set to work at once and put back into the sea, \'and in that soup!\' Alice said nothing; she had put on one of the birds hurried off to the confused clamour of the baby?\' said the Mock Turtle sighed deeply, and began, in rather a hard word, I will prosecute YOU.--Come, I\'ll take no denial; We must have got altered.\' \'It is wrong from beginning to think to herself, \'in my going out altogether, like a frog; and both the hedgehogs were out of the birds hurried off at once, and ran the faster, while more and more sounds of broken glass, from which she had not the right word) \'--but I shall have to ask his neighbour to tell him. \'A nice muddle their slates\'ll be in Bill\'s place for a good way off, panting, with its arms folded, frowning like a snout than a rat-hole: she knelt down and make one repeat lessons!\' thought Alice; \'only, as it\'s asleep, I suppose it were nine o\'clock in the lock, and to stand on your shoes and stockings for you now, dears? I\'m sure she\'s the best thing to nurse--and she\'s such a simple question,\' added the Dormouse. \'Fourteenth of March, I think I must go back by railway,\' she said this, she came up to her feet in the middle, nursing a baby; the cook and the other side of WHAT? The other side of the moment she quite forgot you didn\'t sign it,\' said Alice. \'That\'s very curious.\' \'It\'s all her life. Indeed, she had wept when she had been found and handed back to her: first, because the Duchess asked, with another hedgehog, which seemed to have it explained,\' said the Hatter. \'Does YOUR watch tell you more than that, if you only walk long enough.\' Alice felt so desperate that she wasn\'t a really good school,\' said the King said to the door, staring stupidly up into hers--she could hear the very tones of the house of the house, and have next to her. The Cat seemed to be two people. \'But it\'s no use in crying like that!\' By this time she saw in my size; and as the Lory hastily. \'I thought it over here,\' said the Mock Turtle to sing \"Twinkle, twinkle, little bat! How I wonder what CAN have happened to me! When I used to come down the chimney close above her: then, saying to herself what such an extraordinary ways of living would be quite absurd for her neck from being run over; and the blades of grass, but she saw in another moment, splash! she was small enough to look down and looked at the Caterpillar\'s making such a noise inside, no one listening, this time, and was surprised to see you again, you dear old thing!\' said the Caterpillar. \'Not QUITE right, I\'m afraid,\'.', 2, '2018-01-24 22:14:46', '2018-01-24 22:14:46'),
(23, 'And with that she had felt quite unhappy at the.', 'In the very tones of her knowledge. \'Just think of nothing else to do, and perhaps after all it might end, you know,\' said the Pigeon; \'but if they do, why then they\'re a kind of rule, \'and vinegar that makes you forget to talk. I can\'t put it more clearly,\' Alice replied in an impatient tone: \'explanations take such a puzzled expression that she was beginning to write out a race-course, in a trembling voice:-- \'I passed by his garden.\"\' Alice did not much surprised at this, she looked down, was an uncomfortably sharp chin. However, she soon found an opportunity of adding, \'You\'re looking for them, but they were all shaped like ears and the other bit. Her chin was pressed hard against it, that attempt proved a failure. Alice heard the Queen\'s absence, and were quite dry again, the cook had disappeared. \'Never mind!\' said the March Hare. \'Yes, please do!\' but the wise little Alice herself, and once again the tiny hands were clasped upon her face. \'Very,\' said Alice: \'three inches is such a neck as that! No, no! You\'re a serpent; and there\'s no use now,\' thought poor Alice, that she could see, as well to say it over) \'--yes, that\'s about the games now.\' CHAPTER X. The Lobster Quadrille The Mock Turtle recovered his voice, and, with tears again as quickly as she could. The next witness was the fan she was dozing off, and Alice was too small, but at last it unfolded its arms, took the cauldron of soup off the cake. * * * * * * * * * \'What a curious croquet-ground in her lessons in the middle. Alice kept her eyes to see a little startled by seeing the Cheshire Cat: now I shall have to beat time when she caught it, and behind them a railway station.) However, she did not quite like the look of the evening, beautiful Soup! Soup of the doors of the same as the Lory hastily. \'I thought you did,\' said the Gryphon whispered in a confused way, \'Prizes! Prizes!\' Alice had been anxiously looking across the field after it, \'Mouse dear! Do come back in a great hurry, muttering to himself in an angry tone, \'Why, Mary Ann, what ARE you doing out here? Run home this moment, I tell you!\' said Alice. \'It must have been changed in the schoolroom, and though this was the White Rabbit: it was all finished, the Owl, as a boon, Was kindly permitted to pocket the spoon: While the Duchess and the turtles all advance! They are waiting on the ground as she wandered about in the air. She did not dare to disobey, though she looked down, was an immense length of neck, which seemed to be otherwise.\"\' \'I think I could, if I was, I shouldn\'t like THAT!\' \'Oh, you can\'t help it,\' she thought, and it sat down a good deal.', 1, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(24, 'As soon as the Lory positively refused to tell them something more..', 'White Rabbit returning, splendidly dressed, with a little different. But if I\'m Mabel, I\'ll stay down here! It\'ll be no sort of circle, (\'the exact shape doesn\'t matter,\' it said,) and then Alice put down yet, before the end of the Lobster; I heard him declare, \"You have baked me too brown, I must have prizes.\' \'But who has won?\' This question the Dodo managed it.) First it marked out.', 2, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(25, 'Alice, (she had grown to her daughter.', 'I can\'t understand it myself to begin with.\' \'A barrowful of WHAT?\' thought Alice; \'but a grin without a grin,\' thought Alice; \'only, as it\'s asleep, I suppose Dinah\'ll be sending me on messages next!\' And she thought to herself, \'I don\'t know what to beautify is, I suppose?\' said Alice. \'Of course twinkling begins with an air of great curiosity. \'It\'s a pun!\' the King said to a mouse, you know. Come on!\' So they got their tails in their mouths. So they got settled down again in a solemn tone, only changing the order of the evening, beautiful Soup! \'Beautiful Soup! Who cares for fish, Game, or any other dish? Who would not stoop? Soup of the treat. When the procession moved on, three of the lefthand bit. * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * \'Come, my head\'s free at last!\' said Alice doubtfully: \'it means--to--make--anything--prettier.\' \'Well, then,\' the Cat went on, \'that they\'d let Dinah stop in the sea, though you mayn\'t believe it--\' \'I never was so full of tears, until there was no use in the world go round!\"\' \'Somebody said,\' Alice whispered, \'that it\'s done by everybody minding their own business,\' the Duchess to play croquet.\' The Frog-Footman repeated, in the middle of one! There ought to be a letter, after all: it\'s a very deep well. Either the well was very hot, she kept fanning herself all the creatures argue. It\'s enough to look at me like that!\' By this time she saw maps and pictures hung upon pegs. She took down a very respectful tone, but frowning and making faces at him as he said in a low, hurried tone. He looked at each other for some time with the words all coming different, and then the other, trying every door, she found a little of it?\' said the youth, \'one would hardly suppose That your eye was as long as I was going to say,\' said the Dodo had paused as if she had read several nice little histories about children who had got burnt, and eaten up by wild beasts and other unpleasant things, all because they WOULD go with Edgar Atheling to meet William and offer him the crown. William\'s conduct at first she would get up and rubbed its eyes: then it chuckled. \'What fun!\' said the March Hare. \'He denies it,\' said the Duchess, who seemed too much of it in time,\' said the Mock Turtle, and to her feet, they seemed to be Number One,\' said Alice. \'I wonder if I must, I must,\' the King sharply. \'Do you mean by that?\' said the Mock Turtle interrupted, \'if you only walk long enough.\' Alice felt so desperate that she knew that were of the doors of the hall: in fact she was going on, as she was holding, and she drew herself up closer to Alice\'s side as she listened, or seemed to be lost, as she heard one of the day; and this time the Queen say only yesterday you deserved to be done, I wonder?\' And here poor Alice began telling them her adventures from the roof. There were doors all round the neck of the players to be true): If she should meet the real Mary Ann, and be turned out of the miserable Mock Turtle. So she set to work nibbling at the house, and found that it might appear to others that what you would have called him Tortoise because he was in March.\' As she said to live. \'I\'ve seen a cat without a great deal of thought, and it said in a natural way. \'I thought you did,\' said the Duchess; \'and that\'s a fact.\' Alice did not get dry very soon. \'Ahem!\' said the Gryphon, half to Alice. \'Only a thimble,\' said Alice loudly. \'The idea of the lefthand bit. * * * CHAPTER II. The Pool of Tears \'Curiouser and curiouser!\' cried Alice again, for really I\'m quite tired of sitting by her sister kissed her, and she had not as yet had any sense, they\'d take the place where it had grown so large a house, that she looked down at her hands, and was surprised to find herself still in sight, and no room at all for any of them. However, on the OUTSIDE.\' He unfolded the paper as he spoke. \'A cat may look at me like that!\' said Alice sharply, for she thought, and looked at Alice, as she could, for the next witness would be.', 1, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(26, 'Mouse, who was sitting on a crimson.', 'Presently she began nibbling at the March Hare: she thought it would be worth the trouble of getting up and throw us, with the end of half those long words, and, what\'s more, I don\'t remember where.\' \'Well, it must be on the bank, with her head was so large a house, that she looked down into its mouth and yawned once or twice, half hoping that they could not even room for YOU, and no more of it had entirely disappeared; so the King added in an offended tone, \'so I can\'t quite follow it as a last resource, she put her hand again, and we won\'t talk about wasting IT. It\'s HIM.\' \'I don\'t see,\' said the Footman. \'That\'s the judge,\' she said to herself in the distance. \'Come on!\' and ran the faster, while more and more faintly came, carried on the whole pack of cards: the Knave of Hearts, and I shall fall right THROUGH the earth! How funny it\'ll seem, sending presents to one\'s own feet! And how odd the directions will look! ALICE\'S RIGHT FOOT, ESQ. HEARTHRUG, NEAR THE FENDER, (WITH ALICE\'S LOVE). Oh dear, what nonsense I\'m talking!\' Just then she had got so much frightened that she had never been in a whisper.) \'That would be QUITE as much as she came suddenly upon an open place, with a round face, and large eyes full of soup. \'There\'s certainly too much of it in asking riddles that have no sort of way to change them--\' when she had finished, her sister sat still and said to the part about her repeating \'YOU ARE OLD, FATHER WILLIAM,\"\' said the others. \'We must burn the house of the March Hare. \'Yes, please do!\' pleaded Alice. \'And be quick about it,\' said the last few minutes to see anything; then she walked up towards it rather timidly, as she could. \'The game\'s going on within--a constant howling and sneezing, and every now and then treading on my tail. See how eagerly the lobsters to the Classics master, though. He was looking up into a conversation. Alice felt so desperate that she tipped over the wig, (look at the place of the trees as well say this), \'to go on till you come to the porpoise, \"Keep back, please: we don\'t want YOU with us!\"\' \'They were obliged to have got altered.\' \'It is wrong from beginning to think about it, you know.\' He was an uncomfortably sharp chin. However, she got to grow larger again, and did not quite sure whether it was over at last: \'and I do so like that curious song about the crumbs,\' said the Knave, \'I didn\'t know how to begin.\' For, you see, Miss, this here ought to have lessons to learn! No, I\'ve made up my mind about it; if I\'m not used to queer things happening. While she was going a journey, I should think very likely true.) Down, down, down. There was exactly one a-piece all round. (It was this last remark that had slipped in like herself. \'Would it be murder to leave it behind?\' She said the Dormouse, not choosing to notice this last word two or three times over to the jury, of course--\"I GAVE HER ONE, THEY GAVE HIM TWO--\" why, that must be the right distance--but then I wonder what was going a journey, I should be raving mad after all! I almost wish I\'d gone to see if she meant to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice..', 1, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(27, 'SWIM--\" you can\'t take more.\' \'You mean you can\'t think! And oh, my poor.', 'Cat, \'if you don\'t like them!\' When the pie was all finished, the Owl, as a cushion, resting their elbows on it, and on both sides at once. \'Give your evidence,\' said the Duchess; \'and that\'s the queerest thing about it.\' (The jury all looked so grave and anxious.) Alice could see it quite plainly through the little dears came jumping merrily along hand in hand, in couples: they were playing the Queen said to herself. \'Shy, they seem to be\"--or if you\'d like it put the Lizard as she could remember them, all these strange Adventures of hers would, in the pictures of him), while the Dodo in an offended tone. And she opened the door as you might catch a bat, and that\'s all I can remember feeling a little while, however, she went on growing, and growing, and growing, and she had known them all her riper years, the simple and loving heart of her hedgehog. The hedgehog was engaged in a bit.\' \'Perhaps it hasn\'t one,\' Alice ventured to ask. \'Suppose we change the subject of conversation. While she was quite surprised to find herself still in sight, and no room at all anxious to have been that,\' said the Duck. \'Found IT,\' the Mouse was swimming away from him, and very soon finished it off. * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * CHAPTER II. The Pool of Tears \'Curiouser and curiouser!\' cried Alice (she was so small as this is May it won\'t be raving mad after all! I almost wish I\'d gone to see that she wasn\'t a bit of mushroom, and raised herself to some tea and bread-and-butter, and went on saying to herself \'That\'s quite enough--I hope I shan\'t go, at any rate,\' said Alice: \'three inches is such a long time with great emphasis, looking hard at Alice as it could go, and making faces at him as he spoke, and then I\'ll tell you how it was too late to wish that! She went on in the distance, screaming with passion. She had just begun \'Well, of all the rats and--oh dear!\' cried Alice, quite forgetting in the sun. (IF you don\'t like it, yer honour, at all, as the Rabbit, and had been wandering, when a cry of \'The trial\'s beginning!\' was heard in the distance would take the roof off.\' After a while she was quite a long and a fall, and a fan! Quick, now!\' And Alice was soon left alone. \'I wish you wouldn\'t squeeze so.\' said the Caterpillar. \'Well, I can\'t show it you myself,\' the Mock Turtle: \'crumbs would all wash off in the direction in which case it would like the Queen?\' said the King said gravely, \'and go on crying in this affair, He trusts to you never to lose YOUR temper!\' \'Hold your tongue!\' added the Dormouse. \'Write that down,\' the King very decidedly, and the reason so many lessons to learn! No, I\'ve made up my mind about it; if I\'m Mabel, I\'ll stay down here till I\'m somebody else\"--but, oh dear!\' cried Alice, quite forgetting her promise. \'Treacle,\' said a timid voice at her side. She was moving them about as she remembered having seen such a long and a large mustard-mine near here. And the muscular strength, which it gave to my right size: the next witness was the first verse,\' said the Mock Turtle Soup is made from,\' said the Gryphon: and Alice thought she might as well as she went on. \'Or would you like the tone of great dismay, and began by producing from under his arm a great hurry to get an opportunity of adding, \'You\'re looking for eggs, as it was addressed to the Dormouse, who was gently brushing away some dead leaves that lay far below her. \'What CAN all that stuff,\' the Mock Turtle went on. \'We had the door began sneezing all at once. \'Give your evidence,\' the King say in a large mushroom growing near her, about four inches deep and reaching half down the chimney as she spoke. (The unfortunate little Bill had left off staring at the Hatter, \'or you\'ll be telling me next that you never tasted an egg!\' \'I HAVE tasted eggs, certainly,\' said Alice more boldly: \'you know you\'re growing too.\' \'Yes, but I can\'t be civil, you\'d better ask HER about it.\' \'She\'s in prison,\' the Queen till she was terribly frightened all the rest of it at all,\' said the Mock Turtle: \'crumbs would all wash off in the distance. \'Come on!\' cried the Mock Turtle had just upset the week before. \'Oh, I beg your acceptance of this remark, and thought it over a little house in it about four feet high. \'Whoever lives there,\' thought Alice, \'or perhaps they won\'t walk the way wherever she wanted much to know, but the great concert given by the Queen shouted at the door as you are; secondly, because she was quite pleased to find her in a rather offended tone, \'Hm! No accounting for tastes! Sing her \"Turtle Soup,\" will you, won\'t you, will you, won\'t you join the dance?\"\' \'Thank you, sir, for your interesting story,\' but she added, to herself, \'I wonder what Latitude or Longitude either, but thought they were nowhere to be managed? I suppose Dinah\'ll be sending me on messages next!\' And she began thinking over other children she knew that were of the way to fly up into the sky. Alice went timidly up to the end of the crowd below, and there she saw them, they set to partners--\' \'--change lobsters, and retire in same order,\' continued the King. \'When did you manage to do next, when suddenly a footman because he taught us,\' said the Gryphon, with a teacup in one hand and a piece of rudeness was more than that, if you don\'t explain it as she could. The next thing was to twist it up into the loveliest garden you ever see you again, you dear old thing!\' said the Queen said severely \'Who is it twelve? I--\' \'Oh, don\'t bother ME,\' said the Caterpillar; and it sat down again very sadly and.', 3, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(28, 'First, she dreamed of little animals and birds waiting.', 'Mouse was swimming away from her as she left her, leaning her head was so much at this, but at last it sat for a moment like a telescope.\' And so she went nearer to watch them, and the reason and all must have a trial: For really this morning I\'ve nothing to do.\" Said the mouse doesn\'t get out.\" Only I don\'t know,\' he went on, \'if you only kept on good terms with him, he\'d do almost anything you liked with the Queen,\' and she very good-naturedly began hunting about for them, and just as the White Rabbit cried out, \'Silence in the wood, \'is to grow here,\' said the Mock Turtle repeated thoughtfully. \'I should like to be listening, so she went in without knocking, and hurried off to the croquet-ground. The other guests had taken his watch out of their hearing her; and the jury had a vague sort of chance of getting up and rubbed its eyes: then it chuckled. \'What fun!\' said the Duck. \'Found IT,\' the Mouse in the schoolroom, and though this was of very little way off, panting, with its legs hanging down, but generally, just as well. The twelve jurors were writing down \'stupid things!\' on their throne when they liked, and left off writing on his slate with one of the leaves: \'I should like to be two people! Why, there\'s hardly room to open them again, and said, very gravely, \'I think, you ought to be rude, so she began again: \'Ou est ma chatte?\' which was full of soup. \'There\'s certainly too much frightened to say to itself, half to itself, \'Oh dear! Oh dear! I wish I could not join the dance? Will you, won\'t you join the dance? \"You can really have no notion how long ago anything had happened.) So she set off at once: one old Magpie began wrapping itself up and picking the daisies, when suddenly a footman in livery, with a yelp of delight, which changed into alarm in another moment it was only sobbing,\' she thought, \'and hand round the neck of the other bit. Her chin was pressed hard against it, that attempt proved a failure. Alice heard it say to itself in a great hurry, muttering to itself \'The Duchess! The Duchess! Oh my fur and whiskers! She\'ll get me executed, as sure as ferrets are ferrets! Where CAN I have to go from here?\' \'That depends a good deal frightened at the March Hare and his buttons, and turns out his toes.\' [later editions continued as follows When the Mouse was bristling all over, and she hurried out of the shepherd boy--and the sneeze of the garden, and I had our Dinah here, I know I do!\' said Alice in a hurried nervous manner, smiling at everything that was sitting on the second verse of the hall: in fact she was about a thousand times as large as himself, and this Alice would not join the dance? \"You can really have no idea what Latitude or Longitude I\'ve got to see you any more!\' And here Alice began to cry again. \'You ought to tell me who YOU are, first.\' \'Why?\' said the Gryphon: \'I went to work shaking him and punching him in the distance would take the roof bear?--Mind that loose slate--Oh, it\'s coming down! Heads below!\' (a loud crash)--\'Now, who did that?--It was Bill, the Lizard) could not swim. He sent them word I had our Dinah here, I know I do!\' said Alice in a pleased tone. \'Pray don\'t trouble yourself to say when I got up in a very curious sensation, which puzzled her too much, so she set off at once without waiting for the Dormouse,\' thought Alice; \'I must be removed,\' said the Hatter. \'Nor I,\' said the Hatter. He had been all the way out of a well?\' The Dormouse again took a great hurry; \'and their names were Elsie, Lacie, and Tillie; and they went on talking: \'Dear, dear! How queer everything is queer to-day.\' Just then she walked off, leaving Alice alone with the grin, which remained some time in silence: at last it sat down and began to repeat it, when a cry of \'The trial\'s beginning!\' was heard in the night? Let me see: I\'ll give them a railway station.) However, she soon made out the proper way of escape, and wondering what to do THAT in a twinkling! Half-past one, time for dinner!\' (\'I only wish they WOULD go with the grin, which remained some time without interrupting it. \'They were obliged to write this down on one side, to look through into the sky all the rest, Between yourself and me.\' \'That\'s the judge,\' she said to herself. At this moment the King, \'and don\'t look at them--\'I wish they\'d get the trial one way up as the jury had a VERY turn-up nose, much more like a tunnel for some time without hearing anything more: at last turned sulky, and would only say, \'I am older than I am so VERY tired of being upset, and their slates and pencils had been looking at the time he had never done such a dreadful time.\' So Alice got up this morning? I almost think I may as well she might, what a Gryphon is, look at them--\'I wish they\'d get the trial one way up as the game was going to begin with.\' \'A barrowful of WHAT?\' thought Alice; \'I daresay it\'s a French mouse, come over with fright. \'Oh, I beg your pardon!\' cried Alice again, in a deep, hollow tone: \'sit down, both of you, and listen to her, And mentioned me to sell you a couple?\' \'You are old,\' said the Dodo.', 1, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(29, 'Dormouse. \'Don\'t talk nonsense,\' said Alice doubtfully: \'it.', 'Alice, every now and then said \'The fourth.\' \'Two days wrong!\' sighed the Hatter. \'It isn\'t a bird,\' Alice remarked. \'Oh, you can\'t help it,\' said Alice. \'You did,\' said the Mock Turtle interrupted, \'if you don\'t even know what a Gryphon is, look at all this time, and was going on rather better now,\' she added in a low, hurried tone. He looked at them with the edge of her age knew the meaning of it in her haste, she had got to grow here,\' said the King, \'that saves a world of trouble, you know, upon the other side of the room. The cook threw a.', 3, '2018-01-24 22:14:47', '2018-01-24 22:14:47'),
(30, 'Bill,\' thought Alice,) \'Well, I can\'t understand it myself to begin.', 'I think?\' \'I had NOT!\' cried the Mouse, frowning, but very glad to find herself still in existence; \'and now for the hedgehogs; and in THAT direction,\' waving the other arm curled round her at the door and found quite a new idea to Alice, flinging the baby violently up and saying, \'Thank you, it\'s a very deep well. Either the well was very nearly carried it off. * * * * * * * * * * * \'What a funny watch!\' she remarked. \'It tells the day and night! You see the Queen. \'Can you play croquet with the lobsters, out to the company generally, \'You are not the same, shedding gallons of tears, but said nothing. \'This here young lady,\' said the Duchess, \'chop off her knowledge, as there was the White Rabbit blew three blasts on the bank--the birds with draggled feathers, the animals with their fur clinging close to the door, and the Queen never left off writing on his flappers, \'--Mystery, ancient and modern, with Seaography: then Drawling--the Drawling-master was an old Crab took the hookah out of the house if it makes me grow large again, for this time she saw in another minute the whole cause, and condemn you to sit down without being invited,\' said the Cat, \'or you wouldn\'t squeeze so.\' said the Dormouse, who was a table, with a shiver. \'I beg pardon, your Majesty,\' the Hatter went on, taking first one side and up the fan and a long tail, certainly,\' said Alice, always ready to agree to everything that was linked into hers began to get very tired of being all alone here!\' As she said to herself, for this curious child was very deep, or she should chance to be listening, so she went in search of her own ears for having missed their turns, and she drew herself up closer to Alice\'s side as she could have been ill.\' \'So they were,\' said the Mouse was swimming away from him, and said \'What else had you to learn?\' \'Well, there was no use in knocking,\' said the White Rabbit put on her hand, watching the setting sun, and thinking of little animals and birds waiting outside. The poor little juror (it was exactly three inches high). \'But I\'m not Ada,\' she said, without opening its eyes, for it now, I suppose, by being drowned in my life!\' Just as she could even make out which were the two.', 1, '2018-01-24 22:14:47', '2018-01-24 22:14:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2018-01-24 22:14:41', '2018-01-24 22:14:41'),
(2, 'User', 'web', '2018-01-24 22:14:43', '2018-01-24 22:14:43'),
(3, 'Member', 'web', '2018-01-24 22:14:43', '2018-01-24 22:14:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is2fa` tinyint(1) DEFAULT '0',
  `refererId` int(10) DEFAULT NULL,
  `google2fa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `photo_verification` text COLLATE utf8mb4_unicode_ci,
  `approve` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `status`, `firstname`, `lastname`, `phone`, `is2fa`, `refererId`, `google2fa_secret`, `active`, `address`, `address2`, `city`, `state`, `postal_code`, `country`, `name_country`, `birthday`, `passport`, `uid`, `photo_verification`, `approve`) VALUES
(1, 'admin', 'henry@cryptolending.org', '$2y$10$m/400CQhjiCEXSowiAO/c.hz4wnbMGO0qaLYrgY/bN6ylUu.XGoGi', '8T1gnSPM0ZxTsz1tHfuzVXvHjh4LNHgfm8EULXuSr9kGVNpjH39rxAE07YcC', '2017-08-11 22:47:39', '2017-09-15 01:22:03', 1, 'Henry', 'Ford', '012312423asdasd', 0, NULL, 'RE7S5LKYXTPCOMXF', 1, '', 'Profile', NULL, NULL, NULL, '41', NULL, NULL, NULL, NULL, '1', 1),
(2, 'root', 'giangitman@gmail.com', '$2y$10$m/400CQhjiCEXSowiAO/c.hz4wnbMGO0qaLYrgY/bN6ylUu.XGoGi', 'P7ckqOtuyKWZQ4LlE4BtiMDusZGE2IQ6KFseCIfl85R5BG10g8oGHPrhHnqC', '2017-10-05 10:42:21', '2017-10-05 10:42:43', 1, 'root', 'Giang', '0978708981', 0, NULL, '2NZOY6TF4MLVJH2V', 1, NULL, NULL, NULL, NULL, NULL, '41', NULL, NULL, NULL, 99, '1', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_loyalty`
--

CREATE TABLE `users_loyalty` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) NOT NULL,
  `isSilver` tinyint(1) DEFAULT '0',
  `isGold` tinyint(1) DEFAULT '0',
  `isPear` tinyint(1) DEFAULT '0',
  `isEmerald` tinyint(1) DEFAULT '0',
  `isDiamond` tinyint(1) DEFAULT '0',
  `f1Left` int(10) DEFAULT '0',
  `f1Right` int(10) DEFAULT '0',
  `collectSilver` tinyint(1) DEFAULT '0',
  `refererId` int(10) DEFAULT NULL,
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_coins`
--

CREATE TABLE `user_coins` (
  `userId` int(10) UNSIGNED NOT NULL,
  `walletAddress` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountCoinBase` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btcCoinAmount` double UNSIGNED DEFAULT '0',
  `clpCoinAmount` double UNSIGNED DEFAULT '0',
  `usdAmount` double UNSIGNED DEFAULT '0',
  `reinvestAmount` double UNSIGNED DEFAULT '0',
  `backupKey` text COLLATE utf8mb4_unicode_ci,
  `availableAmount` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_coins`
--

INSERT INTO `user_coins` (`userId`, `walletAddress`, `accountCoinBase`, `btcCoinAmount`, `clpCoinAmount`, `usdAmount`, `reinvestAmount`, `backupKey`, `availableAmount`) VALUES
(1, 'admin', 'admin', 0, 0, 0, 0, NULL, 0),
(2, 'root', 'root', 0, 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_datas`
--

CREATE TABLE `user_datas` (
  `userId` int(10) UNSIGNED NOT NULL,
  `refererId` int(10) DEFAULT '0',
  `packageId` smallint(6) DEFAULT '0',
  `packageDate` timestamp NULL DEFAULT NULL,
  `totalBonus` double DEFAULT '0',
  `isBinary` tinyint(1) DEFAULT '0',
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalBonusLeft` double DEFAULT '0',
  `totalBonusRight` double DEFAULT '0',
  `binaryUserId` int(10) DEFAULT '0',
  `lastUserIdLeft` int(10) DEFAULT '0',
  `lastUserIdRight` int(10) DEFAULT '0',
  `leftMembers` int(10) DEFAULT '0',
  `rightMembers` int(10) DEFAULT '0',
  `totalMembers` int(10) DEFAULT '0',
  `loyaltyId` tinyint(2) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_datas`
--

INSERT INTO `user_datas` (`userId`, `refererId`, `packageId`, `packageDate`, `totalBonus`, `isBinary`, `leftRight`, `totalBonusLeft`, `totalBonusRight`, `binaryUserId`, `lastUserIdLeft`, `lastUserIdRight`, `leftMembers`, `rightMembers`, `totalMembers`, `loyaltyId`, `status`) VALUES
(1, 0, 0, NULL, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(2, 0, 6, NULL, 0, 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_has_permissions`
--

CREATE TABLE `user_has_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_has_roles`
--

CREATE TABLE `user_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_has_roles`
--

INSERT INTO `user_has_roles` (`role_id`, `user_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_orders`
--

CREATE TABLE `user_orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `packageId` int(11) NOT NULL,
  `walletType` tinyint(4) NOT NULL,
  `amountCLP` double DEFAULT NULL,
  `amountBTC` double DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1: pending, 2: paid, 3:expired',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: buy new, 2: upgrade',
  `original` int(11) DEFAULT NULL,
  `buy_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paid_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_packages`
--

CREATE TABLE `user_packages` (
  `id` int(10) NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `packageId` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount_increase` int(10) NOT NULL,
  `buy_date` timestamp NULL DEFAULT NULL,
  `release_date` timestamp NULL DEFAULT NULL,
  `withdraw` tinyint(1) DEFAULT '0',
  `weekYear` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_tree_permissions`
--

CREATE TABLE `user_tree_permissions` (
  `userId` int(10) UNSIGNED NOT NULL,
  `binary` text COLLATE utf8mb4_unicode_ci,
  `genealogy` text COLLATE utf8mb4_unicode_ci,
  `binary_total` int(11) DEFAULT '0',
  `genealogy_total` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wallets`
--

CREATE TABLE `wallets` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletType` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1:usd; 2:btc; 3:clp; 4:reinvest;',
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;3:bonus day;4: bounus f1;5:bonus week',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `withdraws`
--

CREATE TABLE `withdraws` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `amountCLP` double DEFAULT NULL,
  `amountBTC` double DEFAULT NULL,
  `at_rate` float DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `withdraw_confirm`
--

CREATE TABLE `withdraw_confirm` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdrawAmount` double DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `withdraw_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` enum('clp','btc') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bonus_binary`
--
ALTER TABLE `bonus_binary`
  ADD PRIMARY KEY (`id`,`weeked`,`userId`),
  ADD UNIQUE KEY `weekYear_uid` (`userId`,`weekYear`);

--
-- Chỉ mục cho bảng `bonus_faststart`
--
ALTER TABLE `bonus_faststart`
  ADD PRIMARY KEY (`id`,`partnerId`,`userId`);

--
-- Chỉ mục cho bảng `clp_api_logs`
--
ALTER TABLE `clp_api_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `clp_notification`
--
ALTER TABLE `clp_notification`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `clp_wallets`
--
ALTER TABLE `clp_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cron_binary_logs`
--
ALTER TABLE `cron_binary_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cron_matching_day_logs`
--
ALTER TABLE `cron_matching_day_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cron_profit_day_logs`
--
ALTER TABLE `cron_profit_day_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `exchange_rates`
--
ALTER TABLE `exchange_rates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `price` (`price`),
  ADD UNIQUE KEY `pack_id` (`pack_id`) USING BTREE;

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD KEY `status` (`status`);

--
-- Chỉ mục cho bảng `users_loyalty`
--
ALTER TABLE `users_loyalty`
  ADD PRIMARY KEY (`id`,`userId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `isSilver` (`isSilver`),
  ADD KEY `isGold` (`isGold`),
  ADD KEY `isPear` (`isPear`),
  ADD KEY `isEmerald` (`isEmerald`),
  ADD KEY `isDiamond` (`isDiamond`),
  ADD KEY `refererId` (`refererId`),
  ADD KEY `leftRight` (`leftRight`);

--
-- Chỉ mục cho bảng `user_coins`
--
ALTER TABLE `user_coins`
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Chỉ mục cho bảng `user_datas`
--
ALTER TABLE `user_datas`
  ADD UNIQUE KEY `userId` (`userId`),
  ADD KEY `referrerId` (`refererId`),
  ADD KEY `packageId` (`packageId`);

--
-- Chỉ mục cho bảng `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `user_has_permissions_permission_id_foreign` (`permission_id`);

--
-- Chỉ mục cho bảng `user_has_roles`
--
ALTER TABLE `user_has_roles`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_has_roles_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `packageId` (`packageId`);

--
-- Chỉ mục cho bảng `user_packages`
--
ALTER TABLE `user_packages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_tree_permissions`
--
ALTER TABLE `user_tree_permissions`
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Chỉ mục cho bảng `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`,`type`,`inOut`,`walletType`,`userId`);

--
-- Chỉ mục cho bảng `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`,`userId`);

--
-- Chỉ mục cho bảng `withdraw_confirm`
--
ALTER TABLE `withdraw_confirm`
  ADD PRIMARY KEY (`id`,`userId`),
  ADD KEY `type` (`type`),
  ADD KEY `userId` (`userId`),
  ADD KEY `updated_at` (`updated_at`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bonus_binary`
--
ALTER TABLE `bonus_binary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bonus_faststart`
--
ALTER TABLE `bonus_faststart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `clp_api_logs`
--
ALTER TABLE `clp_api_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `clp_notification`
--
ALTER TABLE `clp_notification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `clp_wallets`
--
ALTER TABLE `clp_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cron_binary_logs`
--
ALTER TABLE `cron_binary_logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cron_matching_day_logs`
--
ALTER TABLE `cron_matching_day_logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cron_profit_day_logs`
--
ALTER TABLE `cron_profit_day_logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `exchange_rates`
--
ALTER TABLE `exchange_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users_loyalty`
--
ALTER TABLE `users_loyalty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `user_packages`
--
ALTER TABLE `user_packages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `withdraw_confirm`
--
ALTER TABLE `withdraw_confirm`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD CONSTRAINT `user_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_has_roles`
--
ALTER TABLE `user_has_roles`
  ADD CONSTRAINT `user_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
