-- Migration: Seed cinemas data
-- Version: 1.0
-- Date: 2024

INSERT INTO cinemas (name, slug, province, district, address, phone, email, latitude, longitude, facilities, description) VALUES
('CinemaX Nguyễn Huệ', 'cinemax-nguyen-hue', 'TP. Hồ Chí Minh', 'Quận 1', '123 Nguyễn Huệ, P.Bến Nghé, Q.1', '028-3821-1234', 'nguyen-hue@cinemax.vn', 10.77592000, 106.70088000, ARRAY['IMAX','Dolby Atmos','Parking','F&B'], 'Rạp chiếu phim đẳng cấp tại trung tâm Sài Gòn với công nghệ IMAX và âm thanh Dolby Atmos. Không gian sang trọng, hiện đại với hệ thống ghế cao cấp.'),

('CinemaX Vincom Đồng Khởi', 'cinemax-vincom-dong-khoi', 'TP. Hồ Chí Minh', 'Quận 1', 'Tầng 5, Vincom Center, 72 Lê Thánh Tôn, Q.1', '028-3821-5678', 'dongkhoi@cinemax.vn', 10.77820000, 106.70340000, ARRAY['IMAX','4DX','Sweetbox','Parking'], 'Trải nghiệm điện ảnh 4D sống động với ghế chuyển động, hiệu ứng nước, gió, mùi hương. Phòng Sweetbox dành cho các cặp đôi.'),

('CinemaX Landmark 81', 'cinemax-landmark-81', 'TP. Hồ Chí Minh', 'Bình Thạnh', 'Tầng 3, Landmark 81, 208 Nguyễn Hữu Cảnh, P.22, Q.Bình Thạnh', '028-3512-9999', 'landmark@cinemax.vn', 10.79430000, 106.72190000, ARRAY['IMAX','Dolby Atmos','ScreenX','VIP Lounge'], 'Rạp chiếu phim cao cấp nhất Việt Nam tại tòa nhà cao nhất Đông Nam Á. Công nghệ ScreenX với màn hình 270 độ và VIP Lounge sang trọng.'),

('CinemaX Aeon Mall Tân Phú', 'cinemax-aeon-tan-phu', 'TP. Hồ Chí Minh', 'Tân Phú', 'Tầng 3, Aeon Mall, 30 Bờ Bao Tân Thắng, Q.Tân Phú', '028-3815-4567', 'tanphu@cinemax.vn', 10.80150000, 106.61890000, ARRAY['4DX','Sweetbox','Parking','F&B'], 'Rạp phim hiện đại với công nghệ 4DX và phòng Sweetbox. Nằm trong trung tâm thương mại Aeon Mall với bãi đỗ xe rộng rãi.'),

('CinemaX Times City Hà Nội', 'cinemax-times-city-hn', 'Hà Nội', 'Hai Bà Trưng', 'Tầng 4, Times City, 458 Minh Khai, Q.Hai Bà Trưng', '024-3974-1234', 'timescity@cinemax.vn', 20.99510000, 105.86830000, ARRAY['IMAX','Dolby Atmos','VIP Lounge','Parking'], 'Hệ thống rạp chiếu phim đẳng cấp quốc tế tại Hà Nội với IMAX và Dolby Atmos. VIP Lounge phục vụ đồ ăn cao cấp.'),

('CinemaX Royal City', 'cinemax-royal-city', 'Hà Nội', 'Thanh Xuân', 'Tầng B2, Royal City, 72A Nguyễn Trãi, Q.Thanh Xuân', '024-3974-5678', 'royalcity@cinemax.vn', 21.00280000, 105.81550000, ARRAY['IMAX','4DX','Sweetbox','Parking'], 'Rạp chiếu phim với đầy đủ công nghệ hiện đại: IMAX, 4DX và Sweetbox. Nằm trong trung tâm Royal City với hệ thống F&B đa dạng.'),

('CinemaX Đà Nẵng', 'cinemax-da-nang', 'Đà Nẵng', 'Hải Châu', '35 Lê Duẩn, Q.Hải Châu', '0236-382-1234', 'danang@cinemax.vn', 16.06810000, 108.22120000, ARRAY['IMAX','Parking','F&B'], 'Rạp chiếu phim IMAX đầu tiên tại miền Trung với không gian thoáng mát, view biển đẹp. Bãi đỗ xe rộng rãi.'),

('CinemaX Cần Thơ', 'cinemax-can-tho', 'Cần Thơ', 'Ninh Kiều', 'Tầng 3, Vincom Xuân Khánh, Q.Ninh Kiều', '0292-381-5678', 'cantho@cinemax.vn', 10.02590000, 105.76860000, ARRAY['Dolby Atmos','Sweetbox','F&B','Parking'], 'Rạp chiếu phim hiện đại nhất khu vực ĐBSCL với âm thanh Dolby Atmos và phòng Sweetbox. Không gian sang trọng, dịch vụ chu đáo.'),

('CinemaX Hải Phòng', 'cinemax-hai-phong', 'Hải Phòng', 'Hồng Bàng', 'Tầng 4, AEON Mall Lê Chân, Q.Hồng Bàng', '0225-383-9999', 'haiphong@cinemax.vn', 20.85920000, 106.68850000, ARRAY['IMAX','4DX','Parking'], 'Rạp phim IMAX và 4DX tại Hải Phòng với công nghệ tiên tiến, ghế cao cấp. Nằm trong AEON Mall với nhiều tiện ích mua sắm.'),

('CinemaX Nha Trang', 'cinemax-nha-trang', 'Khánh Hòa', 'Nha Trang', '62 Thái Nguyên, P.Phước Tân, TP.Nha Trang', '0258-352-4567', 'nhatrang@cinemax.vn', 12.24530000, 109.19200000, ARRAY['Dolby Atmos','Sweetbox','F&B'], 'Rạp chiếu phim view biển tại trung tâm Nha Trang với âm thanh Dolby Atmos chất lượng cao. Phòng Sweetbox lãng mạn cho các cặp đôi.');
