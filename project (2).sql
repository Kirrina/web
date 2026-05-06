-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 08:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `tour_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'cash',
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `full_name`, `email`, `phone`, `tour_id`, `booking_date`, `quantity`, `note`, `total_price`, `payment_method`, `status`, `created_at`) VALUES
(1, 3, NULL, NULL, NULL, 4, '2026-03-25 13:38:01', 1, NULL, 3800000, 'cash', 'pending', '2026-05-06 16:41:10'),
(2, 3, NULL, NULL, NULL, 4, '2026-03-25 15:38:10', 9, NULL, 34200000, 'cash', 'pending', '2026-05-06 16:41:10'),
(3, 5, NULL, NULL, NULL, 20, '2026-05-06 16:41:19', 2, '', 10000000, 'cash', 'pending', '2026-05-06 16:41:19'),
(4, 5, NULL, NULL, NULL, 25, '2026-05-06 16:43:05', 2, '', 9400000, 'cash', 'pending', '2026-05-06 16:43:05'),
(5, 5, 'addaad', 'tonykhoa258@gmail.com', '0908473802', 18, '2026-05-06 17:04:01', 2, '', 10000000, 'card', 'pending', '2026-05-06 17:04:01'),
(6, 5, 'addaad', 'tonykhoa258@gmail.com', '0908473802', 20, '2026-05-06 17:04:39', 5, '', 25000000, 'cash', 'pending', '2026-05-06 17:04:39'),
(7, 5, 'addaad', 'tonykhoa258@gmail.com', '0908473802', 16, '2026-05-06 17:07:21', 1, '', 7200000, 'card', 'pending', '2026-05-06 17:07:21'),
(8, 5, 'addaad', 'tonykhoa258@gmail.com', '0908473802', 20, '2026-05-06 17:09:14', 1, '', 5000000, 'card', 'pending', '2026-05-06 17:09:14'),
(9, 5, 'addaad', 'tonykhoa258@gmail.com', '0908473802', 20, '2026-05-06 17:09:47', 3, '', 15000000, 'card', 'pending', '2026-05-06 17:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Tour Trong Nước', 'Khám phá vẻ đẹp mọi miền tổ quốc Việt Nam'),
(2, 'Tour Quốc Tế', 'Du lịch nước ngoài, khám phá văn hóa thế giới'),
(3, 'Tour Nghỉ dưỡng', 'Du lịch nghỉ dưỡng, thư giãn với các dịch vụ đặc biệt');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `tour_id`, `user_id`, `rating`, `content`, `created_at`) VALUES
(44, 1, 2, 5, 'Chuyến đi tuyệt vời, hướng dẫn viên rất chu đáo và nhiệt tình!', '2026-04-01 01:30:00'),
(45, 1, 3, 4, 'Cảnh quan tuyệt đẹp, không khí trong lành, đáng để trải nghiệm.', '2026-04-02 07:15:00'),
(46, 2, 1, 5, 'Gia đình mình đã có một kỳ nghỉ rất ý nghĩa. Dịch vụ tuyệt hảo.', '2026-04-03 02:20:00'),
(47, 2, 3, 4, 'Đồ ăn ngon, giá cả hợp lý, nhưng phòng khách sạn hơi nhỏ.', '2026-04-04 12:45:00'),
(48, 3, 5, 5, 'Cực kỳ hài lòng. Lịch trình sắp xếp hợp lý, không bị mệt.', '2026-04-05 04:10:00'),
(49, 3, 2, 5, 'Được chụp rất nhiều ảnh đẹp. Cảm ơn ekip đã hỗ trợ nhiệt tình!', '2026-04-06 13:05:00'),
(50, 4, 3, 4, 'Chuyến đi ổn, hướng dẫn viên thuyết minh rất hay và lôi cuốn.', '2026-04-07 08:30:00'),
(51, 4, 1, 5, 'Mọi thứ đều hoàn hảo từ lúc đón đến lúc tiễn. Sẽ ủng hộ tiếp.', '2026-04-08 01:50:00'),
(52, 5, 1, 5, 'Rất đáng tiền! Điểm tham quan thú vị, ẩm thực đậm chất địa phương.', '2026-04-09 11:25:00'),
(53, 5, 5, 3, 'Trời mưa nên không đi được hết lịch trình, hơi tiếc một chút.', '2026-04-10 03:40:00'),
(54, 6, 2, 5, 'Biển trong xanh, lặn ngắm san hô là trải nghiệm tuyệt nhất.', '2026-04-11 07:15:00'),
(55, 6, 1, 4, 'Xe đời mới chạy êm, tài xế thân thiện, an toàn.', '2026-04-12 02:00:00'),
(56, 7, 3, 5, 'Vượt xa mong đợi của mình. Khách sạn view siêu xịn xò!', '2026-04-13 14:10:00'),
(57, 7, 3, 5, 'Mọi người trong đoàn rất vui vẻ, kết thêm được nhiều bạn mới.', '2026-04-14 09:20:00'),
(58, 8, 5, 4, 'Chuyến đi mang lại nhiều kiến thức lịch sử bổ ích. Rất hay.', '2026-04-15 04:35:00'),
(59, 8, 2, 5, 'Một hành trình trọn vẹn, công ty tổ chức rất chuyên nghiệp.', '2026-04-16 01:45:00'),
(60, 9, 1, 5, 'Săn mây thành công! Cảnh núi rừng hùng vĩ quá đẹp.', '2026-04-17 12:50:00'),
(61, 9, 3, 4, 'Thời tiết ban đêm hơi lạnh nhưng lửa trại rất vui và ấm cúng.', '2026-04-18 15:15:00'),
(62, 10, 1, 5, 'Nước trong vắt, hải sản rẻ và tươi. Một kỳ nghỉ xả stress hiệu quả.', '2026-04-19 06:20:00'),
(63, 10, 5, 5, 'Tour tổ chức rất tốt, HDV lo cho đoàn từng bữa ăn giấc ngủ.', '2026-04-20 10:05:00'),
(64, 11, 2, 4, 'Điểm đến đẹp nhưng cuối tuần hơi đông đúc một chút.', '2026-04-21 03:10:00'),
(65, 11, 1, 5, 'Chương trình gala dinner rất ấn tượng và nhiều cảm xúc.', '2026-04-22 16:30:00'),
(66, 12, 3, 5, 'Di tích lịch sử đẹp và cổ kính, mang lại cảm giác rất bình yên.', '2026-04-23 02:45:00'),
(67, 12, 2, 5, 'Cảm nhận được nét văn hóa đặc sắc. Rất tuyệt vời!', '2026-04-24 08:25:00'),
(68, 13, 5, 4, 'Đồ ăn hơi cay so với mình nhưng nhìn chung mọi thứ đều tốt.', '2026-04-25 05:10:00'),
(69, 13, 2, 5, 'Hướng dẫn viên tên Nam siêu nhiệt tình và chụp ảnh có tâm.', '2026-04-26 11:00:00'),
(70, 14, 1, 5, 'Không uổng công bay từ xa tới. Cảnh đẹp như một bức tranh.', '2026-04-27 01:20:00'),
(71, 14, 3, 5, 'Phòng ốc sạch sẽ, nhân viên thân thiện. Vote 5 sao!', '2026-04-28 07:35:00'),
(72, 15, 3, 5, 'Thích nhất là trải nghiệm ngồi thuyền ngắm cảnh. Rất thơ mộng.', '2026-04-29 09:50:00'),
(73, 15, 5, 5, 'Chi phí hợp lý, không phát sinh thêm bất kỳ khoản nào.', '2026-04-30 02:15:00'),
(74, 16, 2, 3, 'Xe bị hỏng điều hòa lúc về nên hơi nóng, hy vọng công ty khắc phục.', '2026-05-01 12:40:00'),
(75, 16, 1, 5, 'Một kỳ nghỉ xả hơi đúng nghĩa, cảm ơn công ty rất nhiều.', '2026-05-02 04:25:00'),
(76, 17, 3, 4, 'Về cơ bản là tốt, chỉ có bữa sáng buffet hơi ít món.', '2026-05-03 01:45:00'),
(77, 17, 1, 5, 'Check-in mỏi tay luôn, quá nhiều góc đẹp để sống ảo!', '2026-05-04 13:10:00'),
(78, 18, 5, 5, 'Tour đi bộ trong rừng rất thú vị, hòa mình hoàn toàn vào thiên nhiên.', '2026-05-05 08:00:00'),
(79, 18, 2, 5, 'Lần đầu trải nghiệm ngủ lều, rất vui và đáng nhớ.', '2026-05-06 02:30:00'),
(80, 19, 1, 4, 'Biển êm, cát mịn. Rất thích hợp cho người già và trẻ em.', '2026-05-06 07:20:00'),
(81, 19, 3, 5, 'Dịch vụ spa ở khách sạn quá tuyệt vời, thư giãn hết nấc.', '2026-05-06 11:50:00'),
(82, 20, 1, 5, 'Tất cả mọi thứ đều trên cả tuyệt vời. 10 điểm không có nhưng!', '2026-05-06 13:15:00'),
(83, 20, 5, 5, 'Chuyến đi khép lại bằng một kỷ niệm quá đẹp. Xin cảm ơn!', '2026-05-06 14:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`) VALUES
(1, 'Làm thế nào để biết tour còn đủ chỗ cho nhóm của tôi?', 'Bạn có thể sử dụng bộ lọc \"Số người\" ở cột bên trái. Hệ thống sẽ tự động rà soát và chỉ hiển thị những chuyến đi còn đủ chỗ trống cho nhóm của bạn. Tại trang chi tiết của mỗi tour cũng có hiển thị rõ số lượng vé còn lại.', '2026-05-06 06:48:13'),
(2, 'Giá tour hiển thị trên web đã bao gồm những gì?', 'Mức giá hiển thị là giá trọn gói cơ bản dành cho 1 người lớn. Thông thường đã bao gồm vé máy bay/xe di chuyển, khách sạn tiêu chuẩn và các bữa ăn chính theo lịch trình.', '2026-05-06 06:48:13'),
(3, 'Chính sách hoàn/hủy tour được quy định như thế nào?', 'Chúng tôi áp dụng chính sách hoàn 100% chi phí nếu khách hàng yêu cầu hủy trước 15 ngày khởi hành. Từ 7 đến 14 ngày, mức hoàn lại là 20%.', '2026-05-06 06:48:13'),
(4, 'Tôi có thể thanh toán bằng những hình thức nào?', 'Hệ thống hỗ trợ thanh toán an toàn qua nhiều cổng: Chuyển khoản ngân hàng nội địa, Thẻ tín dụng quốc tế (Visa, Mastercard), Ví điện tử (VNPay) hoặc thanh toán trực tiếp tại văn phòng.', '2026-05-06 06:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'default_tour.jpg',
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `price` int(11) NOT NULL,
  `rate` decimal(3,1) DEFAULT NULL,
  `review_count` int(11) DEFAULT 0,
  `discount` int(11) DEFAULT 0,
  `departure_date` date NOT NULL,
  `duration` varchar(100) DEFAULT '3 ngày 2 đêm',
  `duration_days` int(11) DEFAULT 1,
  `departure_location` varchar(100) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `status` enum('active','hidden') DEFAULT 'active',
  `description` text DEFAULT NULL,
  `itinerary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`itinerary`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `category_id`, `name`, `image`, `gallery`, `price`, `rate`, `review_count`, `discount`, `departure_date`, `duration`, `duration_days`, `departure_location`, `available_seats`, `status`, `description`, `itinerary`) VALUES
(1, 1, 'Khám phá núi rừng Mộc Châu - Trải nghiệm thiên nhiên', '6.jpg', '[\"2.jpg\",\"17.jpg\",\"9.jpg\",\"14.jpg\"]', 7600000, 4.5, 2, 0, '2026-06-22', '4 Ngày 3 Đêm', 4, 'Mộc Châu', 100, 'active', 'Hành trình đến với Mộc Châu sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Mộc Châu\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Mộc Châu. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Mộc Châu, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Mộc Châu về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Mộc Châu, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Mộc Châu về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Mộc Châu\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(2, 1, 'Khám phá núi rừng Sapa - Trải nghiệm thiên nhiên', '6.jpg', '[\"8.jpg\",\"15.jpg\",\"12.jpg\",\"1.jpg\"]', 5300000, 4.5, 2, 0, '2026-08-06', '2 Ngày 1 Đêm', 2, 'Sapa', 100, 'active', 'Hành trình đến với Sapa sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Sapa\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Sapa. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Sapa\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(3, 2, 'Nghỉ dưỡng biển Hạ Long - Tận hưởng đại dương xanh', '1.jpg', '[\"14.jpg\",\"13.jpg\",\"11.jpg\",\"20.jpg\"]', 4800000, 5.0, 2, 0, '2026-05-27', '2 Ngày 1 Đêm', 2, 'Hạ Long', 100, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Hạ Long với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hạ Long\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hạ Long. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Hạ Long\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(4, 2, 'Nghỉ dưỡng biển Hạ Long - Tận hưởng đại dương xanh', '15.jpg', '[\"5.jpg\",\"10.jpg\",\"17.jpg\",\"3.jpg\"]', 3800000, 4.5, 2, 0, '2026-09-09', '4 Ngày 3 Đêm', 4, 'Hạ Long', 100, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Hạ Long với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hạ Long\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hạ Long. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hạ Long, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hạ Long về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hạ Long, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hạ Long về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Hạ Long\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(5, 2, 'Nghỉ dưỡng biển Côn Đảo - Tận hưởng đại dương xanh', '5.jpg', '[\"5.jpg\",\"15.jpg\",\"13.jpg\",\"19.jpg\"]', 7500000, 4.0, 2, 0, '2026-09-04', '4 Ngày 3 Đêm', 4, 'Côn Đảo', 100, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Côn Đảo với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Côn Đảo\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Côn Đảo. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Côn Đảo, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Côn Đảo về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Côn Đảo, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Côn Đảo về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Côn Đảo\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(6, 1, 'Khám phá núi rừng Mộc Châu - Trải nghiệm thiên nhiên', '4.jpg', '[\"16.jpg\",\"1.jpg\",\"2.jpg\",\"17.jpg\"]', 6600000, 4.5, 2, 0, '2026-07-22', '2 Ngày 1 Đêm', 2, 'Mộc Châu', 100, 'active', 'Hành trình đến với Mộc Châu sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Mộc Châu\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Mộc Châu. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Mộc Châu\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(7, 2, 'Nghỉ dưỡng biển Nha Trang - Tận hưởng đại dương xanh', '16.jpg', '[\"19.jpg\",\"7.jpg\",\"11.jpg\",\"16.jpg\"]', 1800000, 5.0, 2, 0, '2026-05-27', '4 Ngày 3 Đêm', 4, 'Nha Trang', 100, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Nha Trang với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Nha Trang\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Nha Trang. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Nha Trang, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Nha Trang về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Nha Trang, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Nha Trang về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Nha Trang\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(8, 3, 'Hành trình di sản Hội An - Vẻ đẹp vượt thời gian', '10.jpg', '[\"11.jpg\",\"17.jpg\",\"20.jpg\",\"9.jpg\"]', 6900000, 4.5, 2, 0, '2026-06-02', '4 Ngày 3 Đêm', 4, 'Hội An', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Hội An, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hội An\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hội An. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hội An, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hội An về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hội An, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hội An về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Hội An\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(9, 3, 'Hành trình di sản Hội An - Vẻ đẹp vượt thời gian', '6.jpg', '[\"15.jpg\",\"10.jpg\",\"1.jpg\",\"19.jpg\"]', 7900000, 4.5, 2, 0, '2026-07-15', '4 Ngày 3 Đêm', 4, 'Hội An', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Hội An, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hội An\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hội An. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hội An, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hội An về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hội An, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hội An về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Hội An\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(10, 3, 'Hành trình di sản Tây Ninh - Vẻ đẹp vượt thời gian', '18.jpg', '[\"7.jpg\",\"4.jpg\",\"14.jpg\",\"15.jpg\"]', 8000000, 5.0, 2, 0, '2026-09-03', '2 Ngày 1 Đêm', 2, 'Tây Ninh', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Tây Ninh, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Tây Ninh\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Tây Ninh. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Tây Ninh\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(11, 3, 'Hành trình di sản Tây Ninh - Vẻ đẹp vượt thời gian', '17.jpg', '[\"7.jpg\",\"3.jpg\",\"10.jpg\",\"19.jpg\"]', 4100000, 4.5, 2, 0, '2026-08-04', '2 Ngày 1 Đêm', 2, 'Tây Ninh', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Tây Ninh, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Tây Ninh\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Tây Ninh. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Tây Ninh\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(12, 1, 'Khám phá núi rừng Mộc Châu - Trải nghiệm thiên nhiên', '13.jpg', '[\"16.jpg\",\"13.jpg\",\"2.jpg\",\"14.jpg\"]', 5600000, 5.0, 2, 0, '2026-08-03', '3 Ngày 2 Đêm', 3, 'Mộc Châu', 100, 'active', 'Hành trình đến với Mộc Châu sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Mộc Châu\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Mộc Châu. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Mộc Châu, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Mộc Châu về đêm.\"}},{\"title\":\"Ngày 3: Tự do mua sắm - Chào tạm biệt Mộc Châu\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(13, 1, 'Khám phá núi rừng Đà Lạt - Trải nghiệm thiên nhiên', '8.jpg', '[\"1.jpg\",\"11.jpg\",\"9.jpg\",\"6.jpg\"]', 4700000, 4.5, 2, 0, '2026-06-03', '4 Ngày 3 Đêm', 4, 'Đà Lạt', 100, 'active', 'Hành trình đến với Đà Lạt sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Đà Lạt\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Đà Lạt. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Đà Lạt, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Đà Lạt về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Đà Lạt, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Đà Lạt về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Đà Lạt\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(14, 3, 'Hành trình di sản Ninh Bình - Vẻ đẹp vượt thời gian', '12.jpg', '[\"1.jpg\",\"14.jpg\",\"15.jpg\",\"3.jpg\"]', 7800000, 5.0, 2, 0, '2026-05-27', '2 Ngày 1 Đêm', 2, 'Ninh Bình', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Ninh Bình, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Ninh Bình\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Ninh Bình. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Ninh Bình\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(15, 1, 'Khám phá núi rừng Hà Giang - Trải nghiệm thiên nhiên', '11.jpg', '[\"7.jpg\",\"12.jpg\",\"4.jpg\",\"13.jpg\"]', 5900000, 5.0, 2, 0, '2026-05-28', '3 Ngày 2 Đêm', 3, 'Hà Giang', 100, 'active', 'Hành trình đến với Hà Giang sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hà Giang\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hà Giang. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hà Giang, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hà Giang về đêm.\"}},{\"title\":\"Ngày 3: Tự do mua sắm - Chào tạm biệt Hà Giang\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(16, 2, 'Nghỉ dưỡng biển Côn Đảo - Tận hưởng đại dương xanh', '4.jpg', '[\"15.jpg\",\"18.jpg\",\"8.jpg\",\"10.jpg\"]', 7200000, 4.0, 2, 0, '2026-06-21', '4 Ngày 3 Đêm', 4, 'Côn Đảo', 99, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Côn Đảo với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Côn Đảo\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Côn Đảo. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Côn Đảo, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Côn Đảo về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Côn Đảo, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Côn Đảo về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Côn Đảo\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(17, 1, 'Khám phá núi rừng Hà Giang - Trải nghiệm thiên nhiên', '3.jpg', '[\"1.jpg\",\"7.jpg\",\"17.jpg\",\"13.jpg\"]', 5400000, 4.5, 2, 0, '2026-05-21', '2 Ngày 1 Đêm', 2, 'Hà Giang', 100, 'active', 'Hành trình đến với Hà Giang sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hà Giang\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hà Giang. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Hà Giang\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(18, 3, 'Hành trình di sản Hội An - Vẻ đẹp vượt thời gian', '18.jpg', '[\"17.jpg\",\"12.jpg\",\"8.jpg\",\"16.jpg\"]', 5000000, 5.0, 2, 0, '2026-08-03', '2 Ngày 1 Đêm', 2, 'Hội An', 98, 'active', 'Cùng quay ngược dòng lịch sử tại Hội An, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hội An\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hội An. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Hội An\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(19, 3, 'Hành trình di sản Huế - Vẻ đẹp vượt thời gian', '7.jpg', '[\"19.jpg\",\"5.jpg\",\"8.jpg\",\"14.jpg\"]', 7300000, 4.5, 2, 0, '2026-08-16', '2 Ngày 1 Đêm', 2, 'Huế', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Huế, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Huế\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Huế. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Huế\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(20, 2, 'Nghỉ dưỡng biển Phú Quốc - Tận hưởng đại dương xanh', '6.jpg', '[\"8.jpg\",\"4.jpg\",\"6.jpg\",\"2.jpg\"]', 5000000, 5.0, 2, 0, '2026-08-06', '2 Ngày 1 Đêm', 2, 'Phú Quốc', 89, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Phú Quốc với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Phú Quốc\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Phú Quốc. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Phú Quốc\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(21, 3, 'Hành trình di sản Hà Nội - Vẻ đẹp vượt thời gian', '10.jpg', '[\"10.jpg\",\"20.jpg\",\"14.jpg\",\"2.jpg\"]', 6900000, NULL, 0, 0, '2026-05-10', '4 Ngày 3 Đêm', 4, 'Hà Nội', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Hà Nội, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hà Nội\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hà Nội. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hà Nội, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hà Nội về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hà Nội, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hà Nội về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Hà Nội\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(22, 1, 'Khám phá núi rừng Cao Bằng - Trải nghiệm thiên nhiên', '5.jpg', '[\"18.jpg\",\"8.jpg\",\"5.jpg\",\"7.jpg\"]', 5200000, NULL, 0, 0, '2026-06-18', '4 Ngày 3 Đêm', 4, 'Cao Bằng', 100, 'active', 'Hành trình đến với Cao Bằng sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Cao Bằng\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Cao Bằng. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Cao Bằng, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Cao Bằng về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Cao Bằng, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Cao Bằng về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Cao Bằng\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(23, 3, 'Hành trình di sản Tây Ninh - Vẻ đẹp vượt thời gian', '15.jpg', '[\"11.jpg\",\"7.jpg\",\"4.jpg\",\"3.jpg\"]', 5200000, NULL, 0, 0, '2026-06-30', '4 Ngày 3 Đêm', 4, 'Tây Ninh', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Tây Ninh, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Tây Ninh\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Tây Ninh. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Tây Ninh, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Tây Ninh về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Tây Ninh, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Tây Ninh về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Tây Ninh\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(24, 2, 'Nghỉ dưỡng biển Hạ Long - Tận hưởng đại dương xanh', '1.jpg', '[\"5.jpg\",\"6.jpg\",\"10.jpg\",\"14.jpg\"]', 7700000, NULL, 0, 0, '2026-09-27', '2 Ngày 1 Đêm', 2, 'Hạ Long', 100, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Hạ Long với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hạ Long\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hạ Long. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Hạ Long\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(25, 3, 'Hành trình di sản Hà Nội - Vẻ đẹp vượt thời gian', '13.jpg', '[\"13.jpg\",\"9.jpg\",\"8.jpg\",\"6.jpg\"]', 4700000, NULL, 0, 0, '2026-08-23', '4 Ngày 3 Đêm', 4, 'Hà Nội', 98, 'active', 'Cùng quay ngược dòng lịch sử tại Hà Nội, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hà Nội\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hà Nội. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hà Nội, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hà Nội về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hà Nội, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hà Nội về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Hà Nội\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(26, 2, 'Nghỉ dưỡng biển Quy Nhơn - Tận hưởng đại dương xanh', '18.jpg', '[\"16.jpg\",\"19.jpg\",\"11.jpg\",\"8.jpg\"]', 2300000, 5.0, 0, 0, '2026-08-26', '4 Ngày 3 Đêm', 4, 'Quy Nhơn', 100, 'active', 'Tận hưởng kỳ nghỉ tuyệt vời tại Quy Nhơn với những bãi biển cát trắng mịn. Trải nghiệm lặn ngắm san hô, thư giãn trên du thuyền và thưởng thức hải sản tươi sống.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Quy Nhơn\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Quy Nhơn. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Quy Nhơn, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Quy Nhơn về đêm.\"}},{\"title\":\"Ngày 3: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Quy Nhơn, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Quy Nhơn về đêm.\"}},{\"title\":\"Ngày 4: Tự do mua sắm - Chào tạm biệt Quy Nhơn\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(27, 3, 'Hành trình di sản Tây Ninh - Vẻ đẹp vượt thời gian', '17.jpg', '[\"3.jpg\",\"20.jpg\",\"8.jpg\",\"18.jpg\"]', 5500000, 5.0, 0, 0, '2026-07-27', '2 Ngày 1 Đêm', 2, 'Tây Ninh', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Tây Ninh, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Tây Ninh\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Tây Ninh. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Tây Ninh\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]');
INSERT INTO `tours` (`id`, `category_id`, `name`, `image`, `gallery`, `price`, `rate`, `review_count`, `discount`, `departure_date`, `duration`, `duration_days`, `departure_location`, `available_seats`, `status`, `description`, `itinerary`) VALUES
(28, 1, 'Khám phá núi rừng Đà Lạt - Trải nghiệm thiên nhiên', '16.jpg', '[\"19.jpg\",\"16.jpg\",\"12.jpg\",\"11.jpg\"]', 5700000, 5.0, 0, 0, '2026-07-23', '3 Ngày 2 Đêm', 3, 'Đà Lạt', 100, 'active', 'Hành trình đến với Đà Lạt sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Đà Lạt\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Đà Lạt. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Đà Lạt, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Đà Lạt về đêm.\"}},{\"title\":\"Ngày 3: Tự do mua sắm - Chào tạm biệt Đà Lạt\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(29, 3, 'Hành trình di sản Hội An - Vẻ đẹp vượt thời gian', '12.jpg', '[\"5.jpg\",\"7.jpg\",\"17.jpg\",\"15.jpg\"]', 5900000, 5.0, 0, 0, '2026-09-25', '3 Ngày 2 Đêm', 3, 'Hội An', 100, 'active', 'Cùng quay ngược dòng lịch sử tại Hội An, nơi lưu giữ những giá trị văn hóa truyền thống, các công trình kiến trúc cổ kính và trải nghiệm nền ẩm thực mang đậm bản sắc.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Hội An\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Hội An. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Khám phá chuyên sâu và Trải nghiệm văn hóa\",\"description\":\"Một ngày trọn vẹn để đi sâu vào các ngóc ngách đẹp nhất của Hội An, tham gia các hoạt động ngoài trời và chụp những bức ảnh check-in tuyệt đẹp.\",\"activities\":{\"07:00\":\"Ăn sáng buffet.\",\"08:30\":\"Di chuyển đến khu du lịch sinh thái\\/di tích lịch sử.\",\"12:00\":\"Nghỉ ngơi và ăn trưa tại nhà hàng.\",\"15:00\":\"Tham gia các hoạt động vui chơi giải trí.\",\"19:00\":\"Ăn tối và tự do khám phá Hội An về đêm.\"}},{\"title\":\"Ngày 3: Tự do mua sắm - Chào tạm biệt Hội An\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]'),
(30, 1, 'Khám phá núi rừng Đà Lạt - Trải nghiệm thiên nhiên', '11.jpg', '[\"19.jpg\",\"7.jpg\",\"11.jpg\",\"12.jpg\"]', 6000000, 5.0, 0, 0, '2026-06-01', '2 Ngày 1 Đêm', 2, 'Đà Lạt', 100, 'active', 'Hành trình đến với Đà Lạt sẽ đưa bạn hòa mình vào cảnh sắc thiên nhiên hoang sơ, chiêm ngưỡng những đồi chè bạt ngàn, săn mây trên đỉnh núi và tìm hiểu văn hóa vùng cao.', '[{\"title\":\"Ngày 1: Đón khách và Bắt đầu hành trình tại Đà Lạt\",\"description\":\"Xe và HDV đón quý khách tại điểm hẹn, khởi hành đi Đà Lạt. Nhận phòng khách sạn, nghỉ ngơi và bắt đầu tham quan các điểm đến đầu tiên.\",\"activities\":{\"08:00\":\"Xe đón đoàn tại trung tâm thành phố.\",\"12:00\":\"Đến nơi, dùng bữa trưa và nhận phòng.\",\"14:30\":\"Tham quan các danh thắng nổi bật trong khu vực.\",\"18:00\":\"Dùng bữa tối thưởng thức đặc sản địa phương.\"}},{\"title\":\"Ngày 2: Tự do mua sắm - Chào tạm biệt Đà Lạt\",\"description\":\"Quý khách tự do vui chơi, mua sắm đặc sản về làm quà cho người thân trước khi lên xe khởi hành về lại điểm đón ban đầu.\",\"activities\":{\"07:30\":\"Dùng điểm tâm sáng tại khách sạn.\",\"09:00\":\"Tự do đi chợ mua sắm quà lưu niệm.\",\"11:30\":\"Làm thủ tục trả phòng khách sạn.\",\"14:00\":\"Lên xe khởi hành về, kết thúc chương trình.\"}}]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default_avatar.jpg',
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','banned') DEFAULT 'active',
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `avatar`, `role`, `status`, `remember_token`, `created_at`) VALUES
(1, 'helllo', 'tonykhoa258@gmail.com', '', '$2y$10$xQf0ld6Vn.rtVFNamc72UuON9c/Kfy3ljgeBryasUVB8Xx5SLXvC2', 'default_avatar.jpg', 'user', 'active', NULL, '2026-03-24 16:33:51'),
(2, 'aa', 'aaaaaaaaa@gmail.com', '', '$2y$10$86Lf03eq7k2t7dabb3sc1O8BjswilRgQZBgVvPbLpkyZi02tTUAB2', 'default_avatar.jpg', 'user', 'active', NULL, '2026-03-24 16:41:35'),
(3, 'addaa', 'ahhh@gmail.com', NULL, '$2y$10$xLhDryl.7G27gB2saGS8C.ES1wJr5/DoBG0pqWN2vJQ5491a2fNrO', 'default_avatar.jpg', 'admin', 'active', NULL, '2026-03-24 16:44:55'),
(5, 'addaad', 'adafd@gmail.com', NULL, '$2y$10$uC8VLf3jplrvOMLXd99ckOLqcZqhL/B5DtNKn4Nom.0omZtvyoz7u', 'default_avatar.jpg', 'admin', 'active', NULL, '2026-05-05 15:54:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `fk_comments_users` (`user_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
