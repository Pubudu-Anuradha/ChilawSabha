--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `shortdesc` varchar(1000) NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `category`, `shortdesc`, `author`) VALUES
(1, 'Testing', 'This is a very special announcement about something.', 'Sarindu Thampath'),
(2, 'Testing', 'This is a very special announcement about something.', 'Sarindu Thampath'),
(3,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(4,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(5,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(6,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(7,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(8,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(9,  'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(10, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(11, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(12, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(13, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(14, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(15, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(16, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(17, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(18, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(19, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(20, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath'),
(21, 'special', 'Lorem ipsum dolor sit amet consectetur adipisicing elit.','Sarindu Thampath');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `views` int(11) NOT NULL,
  `visible_flag` tinyint(1) NOT NULL,
  `visible_start_date` date NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `date`, `views`, `visible_flag`, `visible_start_date`, `type`) VALUES
(1,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(2,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(3,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(4,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(5,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(6,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(7,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(8,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(9,  'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(10, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(11, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(12, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(13, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(14, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(15, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(16, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(17, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(18, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(19, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(20, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement'),
(21, 'A special Announcement', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio\r\n consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse\r\n debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio\r\n natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non\r\n aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi\r\n quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta\r\n alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere\r\n accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam\r\n laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga\r\n praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!\r\n Cum!', '2023-02-01', 0, 1, '2023-02-02', 'announcement');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;