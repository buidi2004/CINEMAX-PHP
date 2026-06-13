-- Seed data for cinemas table
-- 10 cinemas across Vietnam

INSERT INTO cinemas (name, slug, province, district, address, phone, email, latitude, longitude, image_url, opening_hours, description, facilities, is_active) VALUES

-- TP. Hồ Chí Minh (4 rạp)
('CinemaX Nguyễn Huệ', 'cinemax-nguyen-hue', 'TP. Hồ Chí Minh', 'Quận 1', '66 Nguyễn Huệ, Bến Nghé, Quận 1', '028-3824-5678', 'nguyenhue@cinemax.vn', 10.7756790, 106.7019270, '/assets/images/cinemas/nguyen-hue.jpg', '08:00 - 23:30', 'Rạp chiếu phim hiện đại tại trung tâm Quận 1 với hệ thống âm thanh Dolby Atmos và màn hình IMAX.', ARRAY['IMAX', 'Dolby Atmos', 'Sweetbox', 'VIP Lounge', 'Parking', 'F&B'], true),

('CinemaX Vincom Đồng Khởi', 'cinemax-vincom-dong-khoi', 'TP. Hồ Chí Minh', 'Quận 1', '72 Lê Thánh Tôn, Bến Nghé, Quận 1', '028-3936-9999', 'dongkhoi@cinemax.vn', 10.7789150, 106.7018650, '/assets/images/cinemas/dong-khoi.jpg', '09:00 - 00:00', 'Rạp chiếu phim cao cấp trong trung tâm thương mại Vincom với công nghệ 4DX và ScreenX.', ARRAY['4DX', 'ScreenX', 'Dolby Atmos', 'VIP Lounge', 'F&B', 'Parking'], true),

('CinemaX Landmark 81', 'cinemax-landmark-81', 'TP. Hồ Chí Minh', 'Bình Thạnh', '720A Đ. Điện Biên Phủ, Vinhomes Tân Cảng, Bình Thạnh', '028-3970-8888', 'landmark81@cinemax.vn', 10.7947030, 106.7219720, '/assets/images/cinemas/landmark-81.jpg', '09:00 - 00:00', 'Rạp chiếu phim xa xỉ tại tầng cao Landmark 81, tòa nhà cao nhất Việt Nam.', ARRAY['IMAX', 'Dolby Atmos', 'Sweetbox', 'VIP Lounge', 'Private Cinema', 'F&B', 'Valet Parking'], true),

('CinemaX Aeon Mall Tân Phú', 'cinemax-aeon-tan-phu', 'TP. Hồ Chí Minh', 'Tân Phú', '30 Bờ Bao Tân Thắng, Sơn Kỳ, Tân Phú', '028-6268-1111', 'tanphu@cinemax.vn', 10.8037760, 106.6216530, '/assets/images/cinemas/aeon-tan-phu.jpg', '09:00 - 23:00', 'Rạp chiếu phim gia đình trong Aeon Mall với giá vé hợp lý và khu vui chơi trẻ em.', ARRAY['Dolby Atmos', 'Kids Zone', 'F&B', 'Parking'], true),

-- Hà Nội (2 rạp)
('CinemaX Times City Hà Nội', 'cinemax-times-city-hn', 'Hà Nội', 'Hai Bà Trưng', '458 Minh Khai, Vĩnh Tuy, Hai Bà Trưng', '024-6266-9999', 'timescity@cinemax.vn', 20.9997870, 105.8667560, '/assets/images/cinemas/times-city.jpg', '08:00 - 23:30', 'Cụm rạp lớn nhất Hà Nội với 12 phòng chiếu và công nghệ IMAX.', ARRAY['IMAX', '4DX', 'Dolby Atmos', 'VIP Lounge', 'F&B', 'Parking'], true),

('CinemaX Royal City', 'cinemax-royal-city', 'Hà Nội', 'Thanh Xuân', '72A Nguyễn Trãi, Thượng Đình, Thanh Xuân', '024-3974-9999', 'royalcity@cinemax.vn', 21.0007530, 105.8093340, '/assets/images/cinemas/royal-city.jpg', '09:00 - 23:00', 'Rạp chiếu phim cao cấp tại Royal City với hệ thống âm thanh và hình ảnh đẳng cấp.', ARRAY['Dolby Atmos', 'ScreenX', 'Sweetbox', 'VIP Lounge', 'F&B', 'Parking'], true),

-- Đà Nẵng (1 rạp)
('CinemaX Đà Nẵng', 'cinemax-da-nang', 'Đà Nẵng', 'Hải Châu', '255-257 Hùng Vương, Vĩnh Trung, Thanh Khê', '0236-3815-555', 'danang@cinemax.vn', 16.0718800, 108.2145400, '/assets/images/cinemas/danang.jpg', '08:30 - 23:00', 'Rạp chiếu phim hiện đại tại trung tâm Đà Nẵng với view sông Hàn tuyệt đẹp.', ARRAY['IMAX', 'Dolby Atmos', 'VIP Lounge', 'F&B', 'Parking'], true),

-- Cần Thơ (1 rạp)
('CinemaX Cần Thơ', 'cinemax-can-tho', 'Cần Thơ', 'Ninh Kiều', '209 Đường 30/4, Xuân Khánh, Ninh Kiều', '0292-3812-888', 'cantho@cinemax.vn', 10.0342970, 105.7725540, '/assets/images/cinemas/cantho.jpg', '08:00 - 22:30', 'Rạp chiếu phim hàng đầu Tây Nam Bộ với công nghệ chiếu hiện đại.', ARRAY['Dolby Atmos', 'Sweetbox', 'F&B', 'Parking'], true),

-- Hải Phòng (1 rạp)
('CinemaX Hải Phòng', 'cinemax-hai-phong', 'Hải Phòng', 'Lê Chân', '72 Đ. Điện Biên Phủ, Hoàng Văn Thụ, Lê Chân', '0225-3841-999', 'haiphong@cinemax.vn', 20.8531650, 106.6805830, '/assets/images/cinemas/haiphong.jpg', '08:00 - 23:00', 'Rạp chiếu phim hiện đại tại trung tâm thành phố Cảng với phòng chiếu 4DX.', ARRAY['4DX', 'Dolby Atmos', 'VIP Lounge', 'F&B', 'Parking'], true),

-- Nha Trang (1 rạp)
('CinemaX Nha Trang', 'cinemax-nha-trang', 'Khánh Hòa', 'Nha Trang', '72-74 Trần Phú, Lộc Thọ, Nha Trang', '0258-3525-888', 'nhatrang@cinemax.vn', 12.2431690, 109.1943670, '/assets/images/cinemas/nhatrang.jpg', '08:00 - 23:30', 'Rạp chiếu phim view biển tại trung tâm Nha Trang, thích hợp cho du khách.', ARRAY['Dolby Atmos', 'Sweetbox', 'F&B', 'Parking'], true);

-- Verify insertion
SELECT COUNT(*) as total_cinemas FROM cinemas WHERE is_active = true;
