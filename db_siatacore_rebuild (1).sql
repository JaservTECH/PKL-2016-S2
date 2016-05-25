-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2016 at 11:52 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siatacore_rebuild`
--

-- --------------------------------------------------------

--
-- Table structure for table `sc_aa`
--

CREATE TABLE `sc_aa` (
  `a_id` int(11) UNSIGNED NOT NULL,
  `a_year` year(4) NOT NULL,
  `a_semester` tinyint(1) NOT NULL,
  `a_about` tinyint(1) NOT NULL DEFAULT '1',
  `a_registrasi_mulai` date NOT NULL,
  `a_registrasi_berakhir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sc_akeu`
--

CREATE TABLE `sc_akeu` (
  `a_id` datetime NOT NULL,
  `a_event` varchar(225) NOT NULL,
  `a_event_mulai` datetime NOT NULL,
  `a_event_berakhir` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_akeu`
--

INSERT INTO `sc_akeu` (`a_id`, `a_event`, `a_event_mulai`, `a_event_berakhir`) VALUES
('2016-02-10 09:30:50', 'Pendaftaran registrasi TA. Bagi yang baru/melanjutkan', '2016-02-15 00:00:00', '2016-03-17 23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `sc_a_dt`
--

CREATE TABLE `sc_a_dt` (
  `ad_username` varchar(10) NOT NULL,
  `ad_password` varchar(18) NOT NULL,
  `ad_status` varchar(25) NOT NULL,
  `ad_kode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_a_dt`
--

INSERT INTO `sc_a_dt` (`ad_username`, `ad_password`, `ad_status`, `ad_kode`) VALUES
('admin', 'adminif9Default@', 'administrator', '24010316160001'),
('koor', 'koorif9Default@', 'koordinator', '24010316160002');

-- --------------------------------------------------------

--
-- Table structure for table `sc_a_sd`
--

CREATE TABLE `sc_a_sd` (
  `as_id` tinyint(1) NOT NULL,
  `as_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_a_sd`
--

INSERT INTO `sc_a_sd` (`as_id`, `as_name`) VALUES
(1, 'aktif'),
(2, 'tidak aktif');

-- --------------------------------------------------------

--
-- Table structure for table `sc_ea`
--

CREATE TABLE `sc_ea` (
  `e_id` int(10) UNSIGNED NOT NULL,
  `e_year` year(4) NOT NULL,
  `e_semester` tinyint(2) NOT NULL,
  `e_status` tinyint(1) NOT NULL,
  `e_start` date NOT NULL,
  `e_end` date NOT NULL,
  `e_event` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_ea`
--

INSERT INTO `sc_ea` (`e_id`, `e_year`, `e_semester`, `e_status`, `e_start`, `e_end`, `e_event`) VALUES
(2, 2015, 2, 1, '2016-05-11', '2016-05-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sc_ea_event`
--

CREATE TABLE `sc_ea_event` (
  `ee_id` tinyint(2) UNSIGNED NOT NULL,
  `ee_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_ea_event`
--

INSERT INTO `sc_ea_event` (`ee_id`, `ee_name`) VALUES
(1, 'registrasi'),
(2, 'seminar'),
(3, 'koordinator');

-- --------------------------------------------------------

--
-- Table structure for table `sc_ea_status`
--

CREATE TABLE `sc_ea_status` (
  `es_id` tinyint(1) NOT NULL,
  `ea_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_ea_status`
--

INSERT INTO `sc_ea_status` (`es_id`, `ea_name`) VALUES
(1, 'Aktif'),
(2, 'Tidak Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `sc_ko`
--

CREATE TABLE `sc_ko` (
  `k_code_koor` varchar(20) NOT NULL,
  `k_name` varchar(50) NOT NULL,
  `k_email` varchar(75) NOT NULL,
  `k_nohp` varchar(15) NOT NULL,
  `k_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sc_lms`
--

CREATE TABLE `sc_lms` (
  `l_nim` varchar(20) NOT NULL,
  `l_date` datetime NOT NULL,
  `l_event` varchar(50) NOT NULL,
  `l_koor` tinyint(1) UNSIGNED NOT NULL DEFAULT '2',
  `l_mahasiswa` tinyint(1) UNSIGNED NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_lms`
--

INSERT INTO `sc_lms` (`l_nim`, `l_date`, `l_event`, `l_koor`, `l_mahasiswa`) VALUES
('24010313130005', '2016-05-21 11:12:56', 'mendaftar baru', 2, 2),
('24010313130006', '2016-05-21 11:16:38', 'mendaftar baru', 2, 2),
('24010313130006', '2016-05-22 11:33:26', 'Registrasi Baru', 2, 2),
('24010313130006', '2016-05-22 11:34:02', 'Registrasi Baru', 2, 2),
('24010313130006', '2016-05-22 11:50:13', 'Registrasi Baru', 2, 2),
('24010313130006', '2016-05-22 12:24:14', 'Registrasi Baru', 2, 2),
('24010313130006', '2016-05-23 10:23:59', 'Registrasi Lama', 2, 2),
('24010313130007', '2016-05-24 01:13:29', 'mendaftar baru', 2, 2),
('24010313130007', '2016-05-24 01:15:01', 'Registrasi Baru', 2, 2),
('24010313130007', '2016-05-24 01:18:10', 'Registrasi Lama', 2, 2),
('24010313130007', '2016-05-24 06:42:45', 'Registrasi Baru', 2, 2),
('24010313130007', '2016-05-24 07:55:06', 'Registrasi Lama', 2, 2),
('24010313130007', '2016-05-24 10:03:33', 'Registrasi Baru', 2, 2),
('24010313130007', '2016-05-24 10:08:29', 'Registrasi Baru', 2, 2),
('24010313130007', '2016-05-24 10:14:09', 'Registrasi Baru', 2, 2),
('24010313130007', '2016-05-24 10:17:03', 'Registrasi Lama', 2, 2),
('24010313130007', '2016-05-24 10:20:40', 'Registrasi Lama', 2, 2),
('24010313130125', '2016-03-24 15:05:00', 'Rigistrasi Baru', 2, 2),
('24010313130125', '2016-03-24 15:30:02', 'Rigistrasi Baru', 2, 2),
('24010313130125', '2016-03-24 15:34:38', 'Rigistrasi Baru', 2, 2),
('24010313130127', '2015-09-25 02:38:18', 'Rigistrasi Baru', 1, 1),
('24010313130127', '2016-03-23 00:00:00', 'mendaftar baru', 2, 2),
('24010313130127', '2016-03-25 04:14:10', 'Rigistrasi Baru', 2, 2),
('24010313130128', '2014-08-25 07:15:33', 'Rigistrasi Baru', 1, 1),
('24010313130128', '2016-03-23 00:00:00', 'mendaftar baru', 2, 2),
('24010313130128', '2016-03-27 14:03:19', 'Rigistrasi Melanjutkan', 2, 2),
('24010313130128', '2016-03-27 14:06:15', 'Rigistrasi Baru', 2, 2),
('24010313130129', '2016-03-26 00:02:27', 'Rigistrasi Baru', 2, 2),
('24010313130130', '2016-03-26 23:27:04', 'mendaftar baru', 2, 2),
('24010313130130', '2016-03-26 23:29:40', 'mendaftar baru', 2, 2),
('24010313140070', '2016-03-28 08:41:29', 'mendaftar baru', 2, 2),
('24010313140070', '2016-03-28 09:08:36', 'Rigistrasi Baru', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sc_lms_read`
--

CREATE TABLE `sc_lms_read` (
  `lr_id` tinyint(1) UNSIGNED NOT NULL,
  `lr_name` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_lms_read`
--

INSERT INTO `sc_lms_read` (`lr_id`, `lr_name`) VALUES
(1, 'telah dibaca'),
(2, 'belum_dibaca');

-- --------------------------------------------------------

--
-- Table structure for table `sc_sd`
--

CREATE TABLE `sc_sd` (
  `s_id` bigint(20) NOT NULL,
  `s_name` varchar(75) NOT NULL,
  `s_bidang_riset` varchar(100) NOT NULL,
  `s_alamat` varchar(100) NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `s_no_telp` bigint(20) NOT NULL,
  `s_status` tinyint(1) NOT NULL DEFAULT '1',
  `s_password` varchar(18) NOT NULL DEFAULT '@dosbingIF13'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_sd`
--

INSERT INTO `sc_sd` (`s_id`, `s_name`, `s_bidang_riset`, `s_alamat`, `s_email`, `s_no_telp`, `s_status`, `s_password`) VALUES
(195003011979031003, 'Drs.Kushartantya,MI.Komp', 'KG, SC', 'jln lada 2 no. 7', 'kushartantya@yahoo.com', 123456789, 0, '@dosbingIF13'),
(195206101983032001, 'Dra.Indriyati', 'KG, SC', 'Jln kodok bangkong no.9', 'indri@hotmail.com', 123456789, 1, '@dosbingIF13'),
(195306281980031001, 'Drs.Putut Sri Wasito', 'KG, SC', 'jln Banyumanik no. 76', 'PutuSW@yahoo.com', 81326647398, 1, '@dosbingIF13'),
(195412191980031003, 'Drs. Djalal Er Riyanto, M.IKom.', 'STI, RPL', 'jln gagak merah no.56', 'djalal@gmail.com', 81311234561, 1, '@dosbingIF13'),
(195504071983031003, 'Drs. Suhartono, M.Komp.', 'KG, SC', 'jln Belimbing n0.87', 'suhartono@yahoo.com', 81329835946, 1, '@dosbingIF13'),
(196511071992031003, 'Drs. Eko Adi Sarwoko,M.Kom.', 'KG, SC', 'jln bebek remuk no. 57', 'ekoAS@gmail.com', 85728467229, 1, '@dosbingIF13'),
(197007051997021001, 'Priyo Sidik S,S.Si.,M.Kom.', 'KG, SC, RPL', 'jln semut hitam no. 98', 'PriyoSS@gmail.com', 81537495725, 1, '@dosbingIF13'),
(197108111997021004, 'Aris Sugiharto, S.Si.,M.Kom.', 'KG, SC, STI', 'jln Durian runtuh no. 78', 'ArisS@gmail.com', 81274567384, 1, '@dosbingIF13'),
(197601102009122002, 'Dinar Mutiara K.N.,M.Tech.Com.Info', 'RPL, STI', 'jln bali no. 54', 'dinarM@yahoo.com', 55712309789, 1, '@dosbingIF13'),
(197805022005012002, 'Sukmawati Nur Endah M.Kom', 'SC, KG', 'jln Rusa Indah no. 68', 'SukmawatiNE@gmail.com', 85723498472, 1, '@dosbingIF13'),
(197805162003121001, 'Helmie Arif Wibawa,S.Si,M.Cs', 'SC, KG', 'jln Matador no. 99', 'helmieAW@yahoo.com', 85629458657, 1, '@dosbingIF13'),
(197902122008121002, 'Indra Waspada,ST,MTI', 'RPL, KG', 'jln. pipit 2 no.5 semarang', 'maspanji@yahoo.com', 2147483647123, 1, '@dosbingIF13'),
(197905242009121003, 'Sutikno,M.Cs.', 'KG, SC', 'jln taruna no. 65', 'sutiknowae@yahoo.com', 81347578343, 1, '@dosbingIF13'),
(197907202003121002, 'Nurdin Bachtiar,S.Si,MT.', 'STI, RPL, SC', 'jln Cemara no. 67', 'NurdinB@hotmail.com', 81317453987, 1, '@dosbingIF13'),
(198010212005011003, 'Ragil Saputra, S.Si', 'STI, RPL, KG', 'jln  Amerika no. 77', 'Masragil@yahoo.com', 81374593085, 1, '@dosbingIF13'),
(198104212008121002, 'Panji Wisnu Wirawan, ST,MT', 'KG, STI, RPL', 'jln Bulusan no. 66', 'maspanji@gmail.com', 85639844785, 1, '@dosbingIF13'),
(198302032006041002, 'Satriyo Adhy,S.Si', 'STI, RPL', 'jln Nusa Dua no. 88', 'SatrioA@hotmail.com', 81324663798, 1, '@dosbingIF13'),
(1197308291998022001, 'Beta Noranita, S.Si.,M.Kom.', 'STI, RPL', 'jln semut merah no. 99', 'Beta@hotmail.com', 81465937485, 1, '@dosbingIF13');

-- --------------------------------------------------------

--
-- Table structure for table `sc_sk`
--

CREATE TABLE `sc_sk` (
  `s_kode` varchar(15) NOT NULL,
  `s_password` varchar(18) NOT NULL,
  `s_email` varchar(75) NOT NULL,
  `s_contacs` bigint(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_sk`
--

INSERT INTO `sc_sk` (`s_kode`, `s_password`, `s_email`, `s_contacs`) VALUES
('KOOR-IF-SIATA', 'koorif56NEW', 'koorSiata@if.undip.ac.id', 89892839);

-- --------------------------------------------------------

--
-- Table structure for table `sc_sm`
--

CREATE TABLE `sc_sm` (
  `s_nim` varchar(14) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_password` varchar(50) NOT NULL,
  `s_email` varchar(50) NOT NULL,
  `s_statue` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `s_p` tinyint(1) UNSIGNED NOT NULL,
  `s_nohp` varchar(15) NOT NULL,
  `s_active_year` smallint(5) UNSIGNED NOT NULL,
  `s_name_parent` varchar(50) NOT NULL,
  `s_nohp_parent` varchar(15) NOT NULL,
  `s_semester` tinyint(2) NOT NULL,
  `s_new_form` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `s_force_registrasi` smallint(1) NOT NULL DEFAULT '2',
  `s_force_registrasi_lama` smallint(1) NOT NULL DEFAULT '2',
  `s_seminar_ta1` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `s_seminar_ta2` tinyint(1) UNSIGNED NOT NULL DEFAULT '2',
  `s_foto_name` varchar(30) NOT NULL,
  `s_transcript_name` varchar(35) NOT NULL,
  `s_code_cookie` varchar(50) NOT NULL,
  `s_nip_review_1` bigint(20) NOT NULL,
  `s_nip_review_2` bigint(20) NOT NULL,
  `s_nip_review_3` bigint(20) NOT NULL,
  `s_force_seminar_together` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_sm`
--

INSERT INTO `sc_sm` (`s_nim`, `s_name`, `s_password`, `s_email`, `s_statue`, `s_p`, `s_nohp`, `s_active_year`, `s_name_parent`, `s_nohp_parent`, `s_semester`, `s_new_form`, `s_force_registrasi`, `s_force_registrasi_lama`, `s_seminar_ta1`, `s_seminar_ta2`, `s_foto_name`, `s_transcript_name`, `s_code_cookie`, `s_nip_review_1`, `s_nip_review_2`, `s_nip_review_3`, `s_force_seminar_together`) VALUES
('24010313130005', 'Not Mickey Mouse', 'jafar56AA', 'deadmou5@gmail.com', 1, 0, '087829374856', 20152, '', '', 0, 1, 2, 2, 1, 2, '24010313130005-foto.jpg', '24010313130005-transkrip.pdf', '9013c9724ec337888f964426d5a860b0', 0, 0, 0, 0),
('24010313130006', 'Not Mickey Mouse', '912b2928a97f9ec50107292b0a9e8e59', 'deadmou5@gmail.com', 1, 2, '087829315699', 20152, 'siti', '0878293819892', 0, 2, 2, 2, 1, 2, '24010313130006-foto.jpg', '24010313130006-transkrip.pdf', '81c5fa5833ba1efb4dbe3b0f00ea4043', 0, 0, 0, 0),
('24010313130007', 'Not Mickey Mouse', '912b2928a97f9ec50107292b0a9e8e59', 'deadmou5@gmail.com', 1, 1, '087829315699', 20151, 'Husnul', '0878293819892', 0, 2, 2, 2, 1, 2, '24010313130007-foto.jpg', '24010313130007-transkrip.pdf', 'b658f365f5b034664c6dc7a52408a925', 0, 0, 0, 0),
('24010313130125', 'Jafar Abdurrahman Albasyir', '912b2928a97f9ec50107292b0a9e8e59', 'jafarabdurrahmanalbasyir@gmail.com', 1, 1, '087829315699', 20152, 'machludi', '087829315699', 0, 1, 1, 1, 1, 2, '24010313130125-foto.jpg', '24010313130125-transkrip.pdf', 'b1dbe1aae0411a7d20a4143c84d87019', 0, 0, 0, 0),
('24010313130127', 'Lulu Uljannah', '9d6a1d4313083fb7f34f72735ccde982', 'lulu.uljannah@gmail.com', 1, 3, '087829315689', 20152, 'Ujannah', '081256456372', 0, 2, 2, 2, 1, 2, '24010313130127-foto.jpg', '24010313130127-transkrip.pdf', 'b520649f78c64abfc208e33317c051e3', 0, 0, 0, 0),
('24010313130128', 'Julia Indah Pratiwi', '763baa6a33e71f21c22ddfe5cdeb411b', 'juliaindahpratiwi@ugm.ac.id', 1, 2, '087829331678', 20141, 'Pratiwi', '0832893283298', 0, 2, 2, 2, 1, 2, '24010313130128-foto.png', '24010313130128-transkrip.pdf', 'f8c8bd10492e08330b654d4a283c4474', 0, 0, 0, 0),
('24010313130129', 'Siti Husnul Khotimah', '0f7cd8c1c7c9c5e2b22fdf84fbfebef8', 'shkhusnu@ugm.ac.id', 1, 2, '087829331765', 20152, 'Khotimah', '087851755415', 0, 2, 2, 2, 1, 2, '24010313130129-foto.jpg', '24010313130129-transkrip.pdf', '50d0acd9a31ccf6dedc9f14d4eb809cd', 0, 0, 0, 0),
('24010313130130', 'Abdullah Azzam', '538b7d6c881ca50e9fc71fab638d7b6b', 'azzam@gmail.com', 1, 0, '987576666687', 20152, '', '', 0, 1, 2, 2, 1, 2, '24010313130130-foto.jpg', '24010313130130-transkrip.pdf', 'a878fcda6fcc93da5538ea0094134933', 0, 0, 0, 0),
('24010313140070', 'Miqdad Izzudin', 'd26a590918ab89aa9a050dba4a42ffce', 'miqdadizzudin@gmail.com', 1, 3, '0878239898129', 20152, 'albajili', '087829315699', 0, 2, 2, 2, 1, 2, '24010313140070-foto.jpg', '24010313140070-transkrip.pdf', '047255dc7e43992d4aea124c9ede48f6', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sc_sm_interest`
--

CREATE TABLE `sc_sm_interest` (
  `si_id` tinyint(1) UNSIGNED NOT NULL,
  `si_name` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_sm_interest`
--

INSERT INTO `sc_sm_interest` (`si_id`, `si_name`) VALUES
(1, 'Rekayasa Perangkat lunak'),
(2, 'Sistem Informasi'),
(3, 'Sistem Cerdas'),
(4, 'Komputasi');

-- --------------------------------------------------------

--
-- Table structure for table `sc_sm_permissiom`
--

CREATE TABLE `sc_sm_permissiom` (
  `sp_id` tinyint(1) UNSIGNED NOT NULL,
  `sp_name` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_sm_permissiom`
--

INSERT INTO `sc_sm_permissiom` (`sp_id`, `sp_name`) VALUES
(1, 'diizinkan'),
(2, 'dilarang');

-- --------------------------------------------------------

--
-- Table structure for table `sc_sm_statue`
--

CREATE TABLE `sc_sm_statue` (
  `ss_id` tinyint(1) UNSIGNED NOT NULL,
  `ss_name` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_sm_statue`
--

INSERT INTO `sc_sm_statue` (`ss_id`, `ss_name`) VALUES
(1, 'aktif'),
(2, 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `sc_st`
--

CREATE TABLE `sc_st` (
  `s_rt` smallint(5) NOT NULL,
  `s_nim` varchar(20) NOT NULL,
  `s_nip` bigint(20) NOT NULL DEFAULT '0',
  `s_judul_ta` varchar(200) NOT NULL,
  `s_metode` varchar(200) NOT NULL DEFAULT '',
  `s_ref_s` text NOT NULL,
  `s_ref_d` text NOT NULL,
  `s_ref_t` text NOT NULL,
  `s_lokasi` varchar(250) NOT NULL DEFAULT '',
  `s_name_krs` varchar(40) NOT NULL,
  `s_statue` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `s_data_statue` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `s_category` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `s_data_process` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_st`
--

INSERT INTO `sc_st` (`s_rt`, `s_nim`, `s_nip`, `s_judul_ta`, `s_metode`, `s_ref_s`, `s_ref_d`, `s_ref_t`, `s_lokasi`, `s_name_krs`, `s_statue`, `s_data_statue`, `s_category`, `s_data_process`) VALUES
(20142, '24010313130128', 197805022005012002, 'SIstem Informasi Rumah Sakit Ibu Dan Anak', 'waterfall', 'UML modellong for beginner', '', '', 'California', '20152-24010313130128-krs.pdf', 1, 0, 1, 1),
(20152, '24010313130006', 1197308291998022001, 'SIATA NOR MANSK', 'clustering fuzzy ', 'ian sommrvile', '', '', 'Semarang', '20152-24010313130006-krs.pdf', 1, 0, 1, 1),
(20152, '24010313130006', 0, 'Breaking the habit', 'clustering fuzzy ', 'ian sommrvile', '', '', 'Semarang', '20152-24010313130006-krs.pdf', 2, 1, 1, 1),
(20152, '24010313130007', 198104212008121002, 'Degradasi penurunan mesin', 'black box', 'fuzzy clusterring', 'kokokoko', '', 'Semarang', '20152-24010313130007-krs.pdf', 1, 0, 2, 1),
(20152, '24010313130007', 0, 'Degradasi penurunan mesin', 'black box', 'fuzzy clusterring', 'kokokoko', '', 'Semarang', '20152-24010313130007-krs.pdf', 2, 1, 1, 1),
(20152, '24010313130125', 197907202003121002, 'Single picture redeclare', 'deviasi picture control', 'grafika komputasi visual', '', '', 'Cirebon', '20152-24010313130125-krs.pdf', 1, 0, 1, 1),
(20152, '24010313130125', 0, 'Single Threading for multiple thread', 'Thread base control', 'konstruksi Threading', 'gone', '', 'California', '20152-24010313130125-krs.pdf', 2, 1, 1, 1),
(20152, '24010313130125', 0, 'Multiple Threading for Single thread', 'Threading base stuck', 'Threading for develop', '', '', 'Semarang', '20152-24010313130125-krs.pdf', 2, 2, 1, 2),
(20152, '24010313130127', 197907202003121002, 'Chemestry on TI2', 'deviasi picture control', 'grafika komputasi visual', '', '', 'Cirebon', '20152-24010313130127-krs.pdf', 1, 0, 1, 1),
(20152, '24010313130128', 197905242009121003, 'Registrasi SIMKIA', 'Agile', 'Good option', 'UGM for Result SI', '', 'Yogyakarta', '20152-24010313130128-krs.pdf', 1, 0, 1, 1),
(20152, '24010313130128', 197805022005012002, 'SIstem Informasi Rumah Sakit Ibu Dan Anak Yogyakarta', 'waterfall', 'UML modellong for beginner', '', '', 'waterfall', '20152-24010313130128-krs.pdf', 2, 1, 1, 1),
(20152, '24010313130129', 197902122008121002, 'Sistem Informasi UGM', 'Waterfall', 'Waterfall on object session', '', '', 'Yogyakarta', '20152-24010313130129-krs.pdf', 1, 0, 1, 1),
(20152, '24010313140070', 1197308291998022001, 'Tiggelejj dksdh kjd kdj ks', 'hohoo', 'jsdjshd sjdh sjdh sj dh', '', '', 'semarang', '20152-24010313140070-krs.pdf', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sc_st_category`
--

CREATE TABLE `sc_st_category` (
  `sc_id` tinyint(1) UNSIGNED NOT NULL,
  `sc_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_st_category`
--

INSERT INTO `sc_st_category` (`sc_id`, `sc_name`) VALUES
(1, 'baru'),
(2, 'melanjutkan');

-- --------------------------------------------------------

--
-- Table structure for table `sc_st_data_process`
--

CREATE TABLE `sc_st_data_process` (
  `sdp_id` tinyint(1) UNSIGNED NOT NULL,
  `sdp_name` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_st_data_process`
--

INSERT INTO `sc_st_data_process` (`sdp_id`, `sdp_name`) VALUES
(1, 'menunggu'),
(2, 'disetujui'),
(3, 'ditolak');

-- --------------------------------------------------------

--
-- Table structure for table `sc_st_statue`
--

CREATE TABLE `sc_st_statue` (
  `ss_id` tinyint(1) UNSIGNED NOT NULL,
  `ss_name` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sc_st_statue`
--

INSERT INTO `sc_st_statue` (`ss_id`, `ss_name`) VALUES
(1, 'aktif'),
(2, 'sejarah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sc_aa`
--
ALTER TABLE `sc_aa`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `sc_akeu`
--
ALTER TABLE `sc_akeu`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `sc_a_dt`
--
ALTER TABLE `sc_a_dt`
  ADD PRIMARY KEY (`ad_username`);

--
-- Indexes for table `sc_a_sd`
--
ALTER TABLE `sc_a_sd`
  ADD PRIMARY KEY (`as_id`);

--
-- Indexes for table `sc_ea`
--
ALTER TABLE `sc_ea`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `sc_ea_event`
--
ALTER TABLE `sc_ea_event`
  ADD PRIMARY KEY (`ee_id`);

--
-- Indexes for table `sc_ea_status`
--
ALTER TABLE `sc_ea_status`
  ADD PRIMARY KEY (`es_id`);

--
-- Indexes for table `sc_lms`
--
ALTER TABLE `sc_lms`
  ADD PRIMARY KEY (`l_nim`,`l_date`);

--
-- Indexes for table `sc_lms_read`
--
ALTER TABLE `sc_lms_read`
  ADD PRIMARY KEY (`lr_id`);

--
-- Indexes for table `sc_sd`
--
ALTER TABLE `sc_sd`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `sc_sk`
--
ALTER TABLE `sc_sk`
  ADD PRIMARY KEY (`s_kode`);

--
-- Indexes for table `sc_sm`
--
ALTER TABLE `sc_sm`
  ADD PRIMARY KEY (`s_nim`);

--
-- Indexes for table `sc_sm_interest`
--
ALTER TABLE `sc_sm_interest`
  ADD PRIMARY KEY (`si_id`);

--
-- Indexes for table `sc_sm_permissiom`
--
ALTER TABLE `sc_sm_permissiom`
  ADD PRIMARY KEY (`sp_id`);

--
-- Indexes for table `sc_sm_statue`
--
ALTER TABLE `sc_sm_statue`
  ADD PRIMARY KEY (`ss_id`);

--
-- Indexes for table `sc_st`
--
ALTER TABLE `sc_st`
  ADD PRIMARY KEY (`s_rt`,`s_nim`,`s_statue`,`s_data_statue`);

--
-- Indexes for table `sc_st_category`
--
ALTER TABLE `sc_st_category`
  ADD PRIMARY KEY (`sc_id`);

--
-- Indexes for table `sc_st_data_process`
--
ALTER TABLE `sc_st_data_process`
  ADD PRIMARY KEY (`sdp_id`);

--
-- Indexes for table `sc_st_statue`
--
ALTER TABLE `sc_st_statue`
  ADD PRIMARY KEY (`ss_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sc_aa`
--
ALTER TABLE `sc_aa`
  MODIFY `a_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sc_a_sd`
--
ALTER TABLE `sc_a_sd`
  MODIFY `as_id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_ea`
--
ALTER TABLE `sc_ea`
  MODIFY `e_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_ea_event`
--
ALTER TABLE `sc_ea_event`
  MODIFY `ee_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sc_ea_status`
--
ALTER TABLE `sc_ea_status`
  MODIFY `es_id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_lms_read`
--
ALTER TABLE `sc_lms_read`
  MODIFY `lr_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_sm_interest`
--
ALTER TABLE `sc_sm_interest`
  MODIFY `si_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sc_sm_permissiom`
--
ALTER TABLE `sc_sm_permissiom`
  MODIFY `sp_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_sm_statue`
--
ALTER TABLE `sc_sm_statue`
  MODIFY `ss_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_st_category`
--
ALTER TABLE `sc_st_category`
  MODIFY `sc_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sc_st_data_process`
--
ALTER TABLE `sc_st_data_process`
  MODIFY `sdp_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sc_st_statue`
--
ALTER TABLE `sc_st_statue`
  MODIFY `ss_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
