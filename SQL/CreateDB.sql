CREATE TABLE `admin` (
                         `id` int(11) NOT NULL,
                         `name` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `admin`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `admin`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;



CREATE TABLE `trainer` (
                           `id` int(11) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `email` varchar(255) NOT NULL,
                           `password_hash` varchar(255) NOT NULL,
                           `schedule` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `trainer`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `trainer`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;



CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `name` varchar(255) NOT NULL,
                        `email` varchar(255) NOT NULL,
                        `password_hash` varchar(255) NOT NULL,
                        `appointment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
