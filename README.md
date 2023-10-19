# lobard-kyrs
Этот репозиторий содержит исходный код системы управления для ломбарда, разработанной с использованием PHP и MySQL. Система предоставляет функциональность для учета залоговых изделий, оценки их стоимости, а также управления инвентарем ломбарда. 
Данный сайт позволит администратору рассматривать заявки и принимать по ним решения ,а пользователь сможет подавать заявки , просмотратривать или удалять их.


Код для создания таблицы applications

CREATE TABLE applications (
id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(255) NOT NULL,
passport_number VARCHAR(20) NOT NULL,
division_code VARCHAR(10) NOT NULL,
registration_address VARCHAR(255) NOT NULL,
category VARCHAR(255) NOT NULL,
product_name VARCHAR(255) NOT NULL,
selling_price DECIMAL(10, 2) NOT NULL
);
