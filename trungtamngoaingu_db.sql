-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 21, 2025 lúc 10:00 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `trungtamngoaingu_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `capdo_khoahoc`
--

CREATE TABLE `capdo_khoahoc` (
  `CDKH_ID` int(10) NOT NULL,
  `CDKH_ten` varchar(50) NOT NULL,
  `CDKH_mota` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `capdo_khoahoc`
--

INSERT INTO `capdo_khoahoc` (`CDKH_ID`, `CDKH_ten`, `CDKH_mota`) VALUES
(1, 'Chứng chỉ VSTEP', 'Là kỳ thi đánh giá năng lực tiếng Anh theo Khung năng lực ngoại ngữ (NLNN) 6 bậc dùng cho Việt Nam'),
(2, 'IELTS ', 'Là kỳ thi chuẩn Quốc tế giúp đánh giá năng lực tiếng Anh của thí sinh'),
(3, 'TOEIC', 'Được sử dụng làm chuẩn đánh giá các kỹ năng Nghe và Đọc – hai kỹ năng thiết yếu trong tiếng Anh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `capdo_trungtam`
--

CREATE TABLE `capdo_trungtam` (
  `CDTT_ID` int(10) NOT NULL,
  `CDTT_ten` varchar(50) NOT NULL,
  `CDTT_mota` varchar(200) NOT NULL,
  `CDTT_icon` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `capdo_trungtam`
--

INSERT INTO `capdo_trungtam` (`CDTT_ID`, `CDTT_ten`, `CDTT_mota`, `CDTT_icon`) VALUES
(1, 'Trung tâm quốc tế', 'Là tổ chức được công nhận chất lượng bởi các tổ chức quốc tế, trong đó có NEAS', ''),
(2, 'Trung tâm quốc gia', 'Là tổ chức được công nhận chất lượng bởi Nhà nước, đáp ứng đủ yêu cầu để dạy học', ''),
(3, 'Trung tâm địa phương', 'Là tổ chức được công nhận chất lượng Nhà nước, thành lập tại địa phương với quy mô nhỏ', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `DG_noidung` text DEFAULT NULL,
  `DG_sao` int(5) DEFAULT NULL,
  `DG_ngay` date DEFAULT NULL,
  `ND_ID` int(11) NOT NULL,
  `TG_ID` int(11) NOT NULL,
  `TT_ID` int(11) NOT NULL,
  `KH_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_gia`
--

INSERT INTO `danh_gia` (`DG_noidung`, `DG_sao`, `DG_ngay`, `ND_ID`, `TG_ID`, `TT_ID`, `KH_ID`) VALUES
('Chất lượng ok', 5, '2025-03-21', 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giao_vien`
--

CREATE TABLE `giao_vien` (
  `GV_ID` int(10) NOT NULL,
  `GV_ten` varchar(50) NOT NULL,
  `GV_namkn` int(10) NOT NULL,
  `GV_sdt` varchar(11) NOT NULL,
  `GV_email` varchar(50) NOT NULL,
  `GV_quoctich` varchar(50) NOT NULL,
  `GV_chuyenmon` varchar(50) NOT NULL,
  `TT_ID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `giao_vien`
--

INSERT INTO `giao_vien` (`GV_ID`, `GV_ten`, `GV_namkn`, `GV_sdt`, `GV_email`, `GV_quoctich`, `GV_chuyenmon`, `TT_ID`) VALUES
(1, 'Lê Thị Thu Thảo', 2, '0367508196', 'lethithuthao@gmail.com', 'Việt Nam', 'B2', 6),
(2, 'Trần Quốc Hưng', 3, '0761425581', 'tranquochung@gmail.com', 'Việt Nam', 'C1', 1),
(3, 'Ngô Khánh Đăng', 1, '0913123317', 'ngokhanhdang@gmail.com', 'Việt Nam', 'B1', 2),
(4, 'Phạm Thị Lan Anh', 2, '0979123527', 'phamthilananh@gmail.com', 'Việt Nam', 'TOEIC 600', 3),
(5, 'Châu Đình Cẩm Thy', 3, '0367316317', 'chaudinhcamthy@gmail.com', 'Việt Nam', 'EILTS 7.0', 4),
(6, 'Bùi Lan Anh', 3, '0793884667', 'builananh@gmail.com', 'Việt Nam', 'IELTS 7.5', 5),
(7, 'Trần Văn Khởi', 2, '0393668575', 'tranvankhoi@gmail.com', 'Việt Nam', 'IELTS 6.5', 6),
(8, 'Ngô Vĩnh Khang', 1, '0941237676', 'ngovinhkhang@gmail.com', 'Việt Nam', 'TOEIC 550', 7),
(9, 'Nguyễn Minh Huy', 3, '0971483995', 'nguyenminhhuy@gmail.com', 'Việt Nam', 'IELTS 7.5', 8),
(10, 'Trần Ngọc Như', 2, '0364421454', 'tranngocnhu@gmail.com', 'Việt Nam', 'TOEIC 600', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinh_anh`
--

CREATE TABLE `hinh_anh` (
  `HA_ID` int(10) NOT NULL,
  `HA_url` varchar(100) NOT NULL,
  `TT_ID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `hinh_anh`
--

INSERT INTO `hinh_anh` (`HA_ID`, `HA_url`, `TT_ID`) VALUES
(1, '', 1),
(2, '', 2),
(3, '', 3),
(4, '', 4),
(5, '', 5),
(6, '', 6),
(7, '', 7),
(8, '', 8),
(9, '', 9),
(10, '', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoa_hoc`
--

CREATE TABLE `khoa_hoc` (
  `KH_ID` int(10) NOT NULL,
  `KH_ten` varchar(50) NOT NULL,
  `CDKH_ID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `khoa_hoc`
--

INSERT INTO `khoa_hoc` (`KH_ID`, `KH_ten`, `CDKH_ID`) VALUES
(1, 'Chứng chỉ B1', 1),
(2, 'Chứng chỉ IELTS 4.5', 2),
(3, 'Chứng chỉ TOEIC 450', 3),
(4, 'Chứng chỉ B2', 1),
(5, 'Chứng chỉ IELTS 6.5', 2),
(6, 'Chứng chỉ TOEIC 650', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `ND_ID` int(10) NOT NULL,
  `ND_hoten` varchar(50) NOT NULL,
  `ND_sdt` varchar(11) NOT NULL,
  `ND_email` varchar(100) NOT NULL,
  `ND_toado_x` varchar(50) NOT NULL,
  `ND_toado_y` varchar(50) NOT NULL,
  `ND_username` varchar(50) NOT NULL,
  `ND_password` varchar(8) NOT NULL,
  `ND_ROLE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`ND_ID`, `ND_hoten`, `ND_sdt`, `ND_email`, `ND_toado_x`, `ND_toado_y`, `ND_username`, `ND_password`, `ND_ROLE`) VALUES
(1, 'Nguyễn Minh Châu', '0989223456', 'nguyenminhchau@gmail.com', '', '', 'b2110007', '12345678', 2),
(2, 'Phan Thanh Ngân', '0762154471', 'phanthanhngan@gmail.com', '', '', 'b2110050', '12345678', 2),
(3, 'Nguyễn Hà Anh Thư', '0364421455', 'nguyenhaanhthu@gmail.com', '', '', 'b2103479', '12345678', 2),
(4, 'Nguyễn Thị Thanh Nhi', '0979112557', 'nguyenthithanhnhi@gmail.com', '', '', 'b2110052', '12345678', 2),
(5, 'Hồ Minh Thuần', '0929153027', 'hominhthuan@gmail.com', '', '', 'b2110060', '12345678', 2),
(6, 'Ông Thị Hoàng Quyên', '0363272750', 'ongthihoangquyen@gmail.com', '', '', 'b2103474', '12345678', 2),
(7, 'Nguyễn Thái Học', '0939842157', 'nguyenthaihoc@gmail.com', '', '', 'b2012018', '12345678', 2),
(8, 'ADMIN', '0123456789', 'admin@gmail.com', '', '', 'admin', '12345678', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quan_huyen`
--

CREATE TABLE `quan_huyen` (
  `QH_ID` int(10) NOT NULL,
  `QH_ten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `quan_huyen`
--

INSERT INTO `quan_huyen` (`QH_ID`, `QH_ten`) VALUES
(1, 'Ninh Kiều'),
(2, 'Bình Thủy'),
(3, 'Cái Răng'),
(4, 'Ô Môn'),
(5, 'Thốt Nốt'),
(6, 'Vĩnh Thạnh'),
(7, 'Cờ Đỏ'),
(8, 'Thới Lai'),
(9, 'Phong Điền');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thoi_gian`
--

CREATE TABLE `thoi_gian` (
  `TG_ID` int(11) NOT NULL,
  `TG_ngaybatdau` date NOT NULL,
  `TG_thoigian` int(11) NOT NULL,
  `TG_hocphi` double NOT NULL,
  `TT_ID` int(10) NOT NULL,
  `KH_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `thoi_gian`
--

INSERT INTO `thoi_gian` (`TG_ID`, `TG_ngaybatdau`, `TG_thoigian`, `TG_hocphi`, `TT_ID`, `KH_ID`) VALUES
(1, '2025-01-05', 3, 3000000, 1, 1),
(2, '2025-01-06', 6, 3500000, 1, 2),
(3, '2025-01-07', 6, 5500000, 1, 3),
(4, '2025-01-08', 3, 4500000, 1, 4),
(5, '2025-01-09', 6, 8500000, 1, 5),
(6, '2025-01-10', 6, 6500000, 1, 6),
(7, '2025-01-05', 3, 3000000, 2, 1),
(8, '2025-01-06', 6, 3500000, 2, 2),
(9, '2025-01-07', 6, 5500000, 2, 3),
(10, '2025-01-08', 3, 4500000, 2, 4),
(11, '2025-01-09', 6, 8500000, 2, 5),
(12, '2025-01-10', 6, 6500000, 2, 6),
(13, '2025-01-05', 3, 3000000, 3, 1),
(14, '2025-01-06', 6, 3500000, 3, 2),
(15, '2025-01-07', 6, 5500000, 3, 3),
(16, '2025-01-08', 3, 4500000, 3, 4),
(17, '2025-01-09', 6, 8500000, 3, 5),
(18, '2025-01-10', 6, 6500000, 3, 6),
(19, '2025-01-05', 3, 3000000, 4, 1),
(20, '2025-01-06', 6, 3500000, 4, 2),
(21, '2025-01-07', 6, 5500000, 4, 3),
(22, '2025-01-08', 3, 4500000, 4, 4),
(23, '2025-01-09', 6, 8500000, 4, 5),
(24, '2025-01-10', 6, 6500000, 4, 6),
(25, '2025-01-05', 3, 3000000, 5, 1),
(26, '2025-01-06', 6, 3500000, 5, 2),
(27, '2025-01-07', 6, 5500000, 5, 3),
(28, '2025-01-08', 3, 4500000, 5, 4),
(29, '2025-01-09', 6, 8500000, 5, 5),
(30, '2025-01-10', 6, 6500000, 5, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trung_tam`
--

CREATE TABLE `trung_tam` (
  `TT_ID` int(10) NOT NULL,
  `TT_ten` varchar(50) NOT NULL,
  `TT_sdt` varchar(11) NOT NULL,
  `TT_email` varchar(100) NOT NULL,
  `TT_diachi` varchar(200) NOT NULL,
  `TT_toado_x` varchar(50) NOT NULL,
  `TT_toado_y` varchar(50) NOT NULL,
  `CDTT_ID` int(10) NOT NULL,
  `XP_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `trung_tam`
--

INSERT INTO `trung_tam` (`TT_ID`, `TT_ten`, `TT_sdt`, `TT_email`, `TT_diachi`, `TT_toado_x`, `TT_toado_y`, `CDTT_ID`, `XP_ID`) VALUES
(1, 'Trung tâm MILESTONES', '0706558338', 'hotro@milestones.edu.vn', '132-134-136 Trần Văn Trà, P. Hưng Phú, Q. Cái Răng, TP. Cần Thơ', '10.01861', '105.78749', 3, 14),
(2, 'Trung tâm Gia Việt', '0292383100', 'trungtamgiaviet@gmail.com', 'Số 39, Mậu Thân, phường Xuân Khánh, quận Ninh Kiều, thành phố Cần Thơ', '10.03696', '105.77168', 1, 8),
(3, 'Trung tâm AMA', '0292373494', 'amacantho@gmail.com', '60 Lý Hồng Thanh, P. Cái Khế, Q. Ninh Kiều, TP. Cần Thơ', '10.04576', '105.78401', 3, 4),
(4, 'Trung tâm New Windows', '0292629220', 'contact@newwindows.edu.vn', '126A đường 3/2, phường Xuân Khánh, Ninh Kiều, Cần Thơ', '10.02119', '105.76225', 2, 8),
(5, 'Trung tâm ngoại ngữ trường đại học Cần Thơ', '0292365588', 'ttnn@ctu.edu.vn', 'Khu 2 trường đại học Cần Thơ, đường 3/2, Xuân Khánh, Ninh Kiều, Cần Thơ', '10.01723', '105.76588', 2, 8),
(6, 'Trung tâm AMES', '0292373515', 'ames@gmail.com', '118 đường 3/2, phường Xuân Khánh, quận Ninh Kiều, thành phố Cần Thơ', '10.03503', '105.77896', 3, 8),
(7, 'Trung tâm ISEE', '0931115293', 'ngoainguisee@gmail.com', '93/4, Đường Trần Hưng Đạo, An Phú, Ninh Kiều, Cần Thơ', '10.03760', '105.77658', 3, 16),
(8, 'Trung tâm Âu Việt Mỹ', '0916777386', 'auvietmy2018@gmail.com', 'Số 178, Đường 3/2,P. Xuân Khánh, Q. Ninh Kiều, TP. Cần Thơ', '10.02351', '105.76672', 1, 8),
(9, 'Trung tâm ATEN', '0795460092', 'aten@gmail.com', '90 Ngô Sĩ Liên, Khu dân cư Metro, Phường Hưng Lợi, Q. Ninh Kiều, TP Cần Thơ', '10.02081', '105.76027', 3, 5),
(10, 'Trung tâm VIỆT MỸ VATC', '0292373189', 'vietmyvatc@gmail.com', '84 Đ. Mậu Thân, An Nghiệp, Ninh Kiều, Cần Thơ, Vietnam', '10.03745', '105.77215', 1, 16),
(11, 'Trung tâm Quốc tế Sài Gòn ASTON', '0292756888', 'info@aston.edu.vn', 'Số 7 Lý Thái Tổ, P. Hưng Phú, Q. Cái Răng, TP Cần Thơ', '10.01935', '105.78417', 1, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xa_phuong`
--

CREATE TABLE `xa_phuong` (
  `XP_ID` int(10) NOT NULL,
  `XP_ten` varchar(50) NOT NULL,
  `QH_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `xa_phuong`
--

INSERT INTO `xa_phuong` (`XP_ID`, `XP_ten`, `QH_ID`) VALUES
(1, 'An Bình', 1),
(2, 'An Hòa', 1),
(3, 'An Khánh', 1),
(4, 'Cái Khế', 1),
(5, 'Hưng Lợi', 1),
(6, 'Tân An', 1),
(7, 'Thới Bình', 1),
(8, 'Xuân Khánh', 1),
(9, 'Lê Bình', 3),
(10, 'Thường Thạnh', 3),
(11, 'Phú Thứ', 3),
(12, 'Tân Phú', 3),
(13, 'Ba Láng', 3),
(14, 'Hưng Phú', 3),
(15, 'Hưng Thạnh', 3),
(16, 'An Phú', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `capdo_khoahoc`
--
ALTER TABLE `capdo_khoahoc`
  ADD PRIMARY KEY (`CDKH_ID`);

--
-- Chỉ mục cho bảng `capdo_trungtam`
--
ALTER TABLE `capdo_trungtam`
  ADD PRIMARY KEY (`CDTT_ID`);

--
-- Chỉ mục cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`TG_ID`,`TT_ID`,`ND_ID`,`KH_ID`) USING BTREE,
  ADD KEY `TT_ID` (`TT_ID`),
  ADD KEY `KH_ID` (`KH_ID`),
  ADD KEY `ND_ID` (`ND_ID`);

--
-- Chỉ mục cho bảng `giao_vien`
--
ALTER TABLE `giao_vien`
  ADD PRIMARY KEY (`GV_ID`),
  ADD KEY `TT_ID` (`TT_ID`);

--
-- Chỉ mục cho bảng `hinh_anh`
--
ALTER TABLE `hinh_anh`
  ADD PRIMARY KEY (`HA_ID`),
  ADD KEY `TT_ID` (`TT_ID`);

--
-- Chỉ mục cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  ADD PRIMARY KEY (`KH_ID`),
  ADD KEY `CDKH_ID` (`CDKH_ID`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`ND_ID`);

--
-- Chỉ mục cho bảng `quan_huyen`
--
ALTER TABLE `quan_huyen`
  ADD PRIMARY KEY (`QH_ID`);

--
-- Chỉ mục cho bảng `thoi_gian`
--
ALTER TABLE `thoi_gian`
  ADD PRIMARY KEY (`TG_ID`,`TT_ID`,`KH_ID`),
  ADD KEY `TT_ID` (`TT_ID`),
  ADD KEY `KH_ID` (`KH_ID`);

--
-- Chỉ mục cho bảng `trung_tam`
--
ALTER TABLE `trung_tam`
  ADD PRIMARY KEY (`TT_ID`),
  ADD KEY `CDTT_ID` (`CDTT_ID`),
  ADD KEY `XP_ID` (`XP_ID`);

--
-- Chỉ mục cho bảng `xa_phuong`
--
ALTER TABLE `xa_phuong`
  ADD PRIMARY KEY (`XP_ID`),
  ADD KEY `QH_ID` (`QH_ID`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`TG_ID`) REFERENCES `thoi_gian` (`TG_ID`),
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`TT_ID`) REFERENCES `thoi_gian` (`TT_ID`),
  ADD CONSTRAINT `danh_gia_ibfk_3` FOREIGN KEY (`KH_ID`) REFERENCES `thoi_gian` (`KH_ID`),
  ADD CONSTRAINT `danh_gia_ibfk_4` FOREIGN KEY (`ND_ID`) REFERENCES `nguoi_dung` (`ND_ID`),
  ADD CONSTRAINT `danh_gia_ibfk_5` FOREIGN KEY (`TG_ID`) REFERENCES `thoi_gian` (`TG_ID`);

--
-- Các ràng buộc cho bảng `giao_vien`
--
ALTER TABLE `giao_vien`
  ADD CONSTRAINT `giao_vien_ibfk_1` FOREIGN KEY (`TT_ID`) REFERENCES `trung_tam` (`TT_ID`);

--
-- Các ràng buộc cho bảng `hinh_anh`
--
ALTER TABLE `hinh_anh`
  ADD CONSTRAINT `hinh_anh_ibfk_1` FOREIGN KEY (`TT_ID`) REFERENCES `trung_tam` (`TT_ID`);

--
-- Các ràng buộc cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  ADD CONSTRAINT `khoa_hoc_ibfk_1` FOREIGN KEY (`CDKH_ID`) REFERENCES `capdo_khoahoc` (`CDKH_ID`);

--
-- Các ràng buộc cho bảng `thoi_gian`
--
ALTER TABLE `thoi_gian`
  ADD CONSTRAINT `thoi_gian_ibfk_1` FOREIGN KEY (`TT_ID`) REFERENCES `trung_tam` (`TT_ID`),
  ADD CONSTRAINT `thoi_gian_ibfk_2` FOREIGN KEY (`KH_ID`) REFERENCES `khoa_hoc` (`KH_ID`);

--
-- Các ràng buộc cho bảng `trung_tam`
--
ALTER TABLE `trung_tam`
  ADD CONSTRAINT `trung_tam_ibfk_1` FOREIGN KEY (`CDTT_ID`) REFERENCES `capdo_trungtam` (`CDTT_ID`),
  ADD CONSTRAINT `trung_tam_ibfk_2` FOREIGN KEY (`XP_ID`) REFERENCES `xa_phuong` (`XP_ID`);

--
-- Các ràng buộc cho bảng `xa_phuong`
--
ALTER TABLE `xa_phuong`
  ADD CONSTRAINT `xa_phuong_ibfk_1` FOREIGN KEY (`QH_ID`) REFERENCES `quan_huyen` (`QH_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
