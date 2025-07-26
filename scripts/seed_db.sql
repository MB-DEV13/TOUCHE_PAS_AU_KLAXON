USE covoiturage;

-- Insertion des agences
INSERT INTO agence (nom) VALUES
('Paris'),('Lyon'),('Marseille'),('Toulouse'),('Nice'),('Nantes'),('Strasbourg'),('Montpellier'),('Bordeaux'),('Lille'),('Rennes'),('Reims');

-- Insertion des utilisateurs
INSERT INTO utilisateur (nom, prenom, telephone, email, password, role) VALUES
('Administrator','Admin','0700000000','admin@entreprise.fr','$2b$12$Zweet0fqzu9DLAhERPv.ru2qVQUbtlkUlVczDMwcdAyMUcjc5V/Zm','admin'),
('Martin','Alexandre','0612345678','alexandre.martin@email.fr','$2b$12$85heSoAgp5arG/yHOwcY0uYfcJBju4HkoySsxpitVk9dvEU/hthDy','user'),
('Dubois','Sophie','0698765432','sophie.dubois@email.fr','$2b$12$fPU4yTtG0Tmz7k7KAgpN8.PSiQeKmZHPUYL.Hurt429BL.4M8re9i','user'),
('Bernard','Julien','0622446688','julien.bernard@email.fr','$2b$12$W3HtNhCjXA7DqITetKpOs.Ko4dIsMx8k6PslQOf/7.2SMO9IDITzK','user'),
('Moreau','Camille','0611223344','camille.moreau@email.fr','$2b$12$LAdXTuPg18AJXki/m47d4.iyYxGPw6FSyxtprx8oeqGh68N4uRU.y','user'),
('Lefèvre','Lucie','0777889900','lucie.lefevre@email.fr','$2b$12$9X24qX0m3fpMMPAg0zG1MeLPZjdfwgymi89zVB6wliQcueThrdKX.','user'),
('Leroy','Thomas','0655443322','thomas.leroy@email.fr','$2b$12$Y4AM1228j7kcX2OaBF3lF.Ii37pgN9sC2CZShjRn25plIxrIp40LW','user'),
('Roux','Chloé','0633221199','chloe.roux@email.fr','$2b$12$OzJHROd2KClJyo278WGeEOxizfEhJjzVNKVqkJ3/YY/DOeENTK6OO','user'),
('Petit','Maxime','0766778899','maxime.petit@email.fr','$2b$12$pXoY0TwDC/lWrLJY5vtqLOHZhG4WCQJw9VkM6lcAl94E6xVKyRzHG','user'),
('Garnier','Laura','0688776655','laura.garnier@email.fr','$2b$12$5uYcu4ZNlpC9SkNmGTDyNe49P3G35/IObGhNvkQ9b0c9ujweugabK','user'),
('Dupuis','Antoine','0744556677','antoine.dupuis@email.fr','$2b$12$lRTJjwt5fG.fQ4Ydrua2V.xFlc2OqzNMp8PiHJpD1SI1UHibSbUV.','user'),
('Lefebvre','Emma','0699887766','emma.lefebvre@email.fr','$2b$12$IRdWQuOCSbQV5AA4HKolH.ANGVMphJUW/0s0bKsjg3o7yUfL20UZW','user'),
('Fontaine','Louis','0655667788','louis.fontaine@email.fr','$2b$12$ZKtx1SiJCbmngjCJ1HDTqepkMtPeI6a.jaTgMYZlRfO1de4XnNV36','user'),
('Chevalier','Clara','0788990011','clara.chevalier@email.fr','$2b$12$jg.wl6zPAVxVl7VAt8bay.Hqbtabd081s/zlhkpE2QEKx6Lbg1ERy','user'),
('Robin','Nicolas','0644332211','nicolas.robin@email.fr','$2b$12$PVVvtHD5WJIH61wNhYwMpOCHEmTJJwk/P/SwbK5Z5c8VAHgUGUddS','user'),
('Gauthier','Marine','0677889922','marine.gauthier@email.fr','$2b$12$DXNIA4gJkoQ0qtlD2sFp3uv6F5hXR.n7dlJUeckN.vs8TP8..wh0e','user'),
('Fournier','Pierre','0722334455','pierre.fournier@email.fr','$2b$12$0/xBgRyuAz6ML74CUEfIN.FZLN6jgfzZxAMVhkuAT99D/CKz2CB.6','user'),
('Girard','Sarah','0688665544','sarah.girard@email.fr','$2b$12$THlT4igripZGgBKaQR10C.K4zJZwvTvh5xcjIL2/nEEKHzATtqFxG','user'),
('Lambert','Hugo','0611223366','hugo.lambert@email.fr','$2b$12$nE0XefT1zxn9qHeQN5w18uXZGkC6zLtf5j8D7oeHKa95e5xYS7waW','user'),
('Masson','Julie','0733445566','julie.masson@email.fr','$2b$12$c0w4mzHT3eBbWuQwPTaNEOSMsaj/VbMPpH5e7AhO3DxFB9wIz.mZe','user'),
('Henry','Arthur','0666554433','arthur.henry@email.fr','$2b$12$uIUZY5cWsKIHlYGN0BN64.B37M3UBNXhW872wngRFWcSeEBI0as3G','user');
