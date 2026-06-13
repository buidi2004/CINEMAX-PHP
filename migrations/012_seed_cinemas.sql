-- migrations/012_seed_cinemas.sql

INSERT IGNORE INTO cinemas (name, slug, province, district, address, phone, latitude, longitude, facilities, image_url) VALUES
('CinemaX Nguyễn Huệ',      'cinemax-nguyen-hue',      'TP. Hồ Chí Minh', 'Quận 1',       '123 Nguyễn Huệ, P.Bến Nghé, Q.1',        '028-3821-1234', 10.77592000, 106.70088000, '["IMAX","Dolby Atmos","Parking","F&B"]', '/assets/images/cinemas/nguyen-hue.jpg'),
('CinemaX Vincom Đồng Khởi', 'cinemax-vincom-dong-khoi','TP. Hồ Chí Minh', 'Quận 1',       'Tầng 5, Vincom Center, 72 Lê Thánh Tôn',  '028-3821-5678', 10.77820000, 106.70340000, '["IMAX","4DX","Sweetbox","Parking"]', '/assets/images/cinemas/vincom-dk.jpg'),
('CinemaX Landmark 81',      'cinemax-landmark-81',      'TP. Hồ Chí Minh', 'Bình Thạnh',   'Tầng 3, Landmark 81, 208 Nguyễn Hữu Cảnh','028-3512-9999', 10.79430000, 106.72190000, '["IMAX","Dolby Atmos","ScreenX","VIP Lounge"]', '/assets/images/cinemas/landmark81.jpg'),
('CinemaX Aeon Mall Tân Phú','cinemax-aeon-tan-phu',    'TP. Hồ Chí Minh', 'Tân Phú',      'Tầng 3, Aeon Mall, 30 Bờ Bao Tân Thắng',  '028-3815-4567', 10.80150000, 106.61890000, '["4DX","Sweetbox","Parking","F&B"]', '/assets/images/cinemas/aeon-tp.jpg'),
('CinemaX Times City',       'cinemax-times-city-hn',    'Hà Nội',          'Hai Bà Trưng',  'Tầng 4, Times City, 458 Minh Khai',        '024-3974-1234', 20.99510000, 105.86830000, '["IMAX","Dolby Atmos","VIP Lounge"]', '/assets/images/cinemas/times-city.jpg'),
('CinemaX Royal City',       'cinemax-royal-city',       'Hà Nội',          'Thanh Xuân',    'Tầng B2, Royal City, 72A Nguyễn Trãi',     '024-3974-5678', 21.00280000, 105.81550000, '["IMAX","4DX","Sweetbox","Parking"]', '/assets/images/cinemas/royal-city.jpg'),
('CinemaX Đà Nẵng',          'cinemax-da-nang',          'Đà Nẵng',         'Hải Châu',     '35 Lê Duẩn, Q.Hải Châu, TP.Đà Nẵng',      '0236-382-1234', 16.06810000, 108.22120000, '["IMAX","Parking","F&B"]', '/assets/images/cinemas/da-nang.jpg'),
('CinemaX Cần Thơ',          'cinemax-can-tho',          'Cần Thơ',         'Ninh Kiều',    'Tầng 3, Vincom Xuân Khánh, Q.Ninh Kiều',   '0292-381-5678', 10.02590000, 105.76860000, '["Dolby Atmos","Sweetbox","F&B"]', '/assets/images/cinemas/can-tho.jpg'),
('CinemaX Hải Phòng',        'cinemax-hai-phong',        'Hải Phòng',       'Hồng Bàng',    'Tầng 4, AEON Mall Lê Chân, Q.Hồng Bàng',   '0225-383-9999', 20.85920000, 106.68850000, '["IMAX","4DX","Parking"]', '/assets/images/cinemas/hai-phong.jpg'),
('CinemaX Nha Trang',        'cinemax-nha-trang',        'Khánh Hòa',       'Nha Trang',    '62 Thái Nguyên, P.Phước Tân, TP.Nha Trang', '0258-352-4567', 12.24530000, 109.19200000, '["Dolby Atmos","Sweetbox","F&B"]', '/assets/images/cinemas/nha-trang.jpg');

-- Link existing rooms to first cinema
UPDATE rooms SET cinema_id = 1 WHERE cinema_id IS NULL;
