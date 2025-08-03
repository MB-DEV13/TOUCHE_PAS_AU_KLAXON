USE `covoiturage`;

-- Données agence
INSERT INTO `agence` (`id_agence`, `nom`) VALUES
(14, 'Avignon'),
(23, 'Bordeaux'),
(10, 'Lille'),
(2, 'Lyon'),
(3, 'Marseille'),
(20, 'Monaco'),
(8, 'Montpellier'),
(6, 'Nantes'),
(5, 'Nice'),
(22, 'Paris'),
(12, 'Reims'),
(11, 'Rennes'),
(7, 'Strasbourg'),
(4, 'Toulouse'),
(17, 'Vichy');

-- Données utilisateur
INSERT INTO `utilisateur` (`id_user`, `nom`, `prenom`, `telephone`, `email`, `password`, `role`) VALUES
(1, '', 'Admin', '0700000000', 'admin@entreprise.fr', '$2y$10$dC8.GMIXSPItv9ixkTCDu.x/GZ6vD4hO1HRmUyGjkPha2zfXJ0fyS', 'admin'),
(2, 'Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$VzcF.lWHw5e3AnWnMtF2leXGkJY5H10BHNGAW10RnB5kIXnTITCd2', 'user'),
(3, 'Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$3KGfEUrH1D08NoHFHa7t5ekhLA2OmKQovg7UKavdXM.I4pyTIc.G2', 'user'),
(4, 'Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2b$12$W3HtNhCjXA7DqITetKpOs.Ko4dIsMx8k6PslQOf/7.2SMO9IDITzK', 'user'),
(5, 'Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2b$12$LAdXTuPg18AJXki/m47d4.iyYxGPw6FSyxtprx8oeqGh68N4uRU.y', 'user'),
(6, 'Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2b$12$9X24qX0m3fpMMPAg0zG1MeLPZjdfwgymi89zVB6wliQcueThrdKX.', 'user'),
(7, 'Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2b$12$Y4AM1228j7kcX2OaBF3lF.Ii37pgN9sC2CZShjRn25plIxrIp40LW', 'user'),
(8, 'Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2b$12$OzJHROd2KClJyo278WGeEOxizfEhJjzVNKVqkJ3/YY/DOeENTK6OO', 'user'),
(9, 'Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2b$12$pXoY0TwDC/lWrLLJY5vtqLOHZhG4WCQJw9VkM6lcAl94E6xVKyRzHG', 'user'),
(10, 'Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2b$12$5uYcu4ZNlpC9SkNmGTDyNe49P3G35/IObGhNvkQ9b0c9ujweugabK', 'user'),
(11, 'Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2b$12$lRTJjwt5fG.fQ4Ydrua2V.xFlc2OqzNMp8PiHJpD1SI1UHibSbUV.', 'user'),
(12, 'Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2b$12$IRdWQuOCSbQV5AA4HKolH.ANGVMphJUW/0s0bKsjg3o7yUfL20UZW', 'user'),
(13, 'Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2b$12$ZKtx1SiJCbmngjCJ1HDTqepkMtPeI6a.jaTgMYZlRfO1de4XnNV36', 'user'),
(14, 'Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2b$12$jg.wl6zPAVxVl7VAt8bay.Hqbtabd081s/zlhkpE2QEKx6Lbg1ERy', 'user'),
(15, 'Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2b$12$PVVvtHD5WJIH61wNhYwMpOCHEmTJJwk/P/SwbK5Z5c8VAHgUGUddS', 'user'),
(16, 'Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2b$12$DXNIA4gJkoQ0qtlD2sFp3uv6F5hXR.n7dlJUeckN.vs8TP8..wh0e', 'user'),
(17, 'Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2b$12$0/xBgRyuAz6ML74CUEfIN.FZLN6jgfzZxAMVhkuAT99D/CKz2CB.6', 'user'),
(18, 'Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2b$12$THlT4igripZGgBKaQR10C.K4dIsMx8k6PslQOf/7.2SMO9IDITzK', 'user'),
(19, 'Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2b$12$nE0XefT1zxn9qHeQN5w18uXZGkC6zLtf5j8D7oeHKa95e5xYS7waW', 'user'),
(20, 'Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2b$12$c0w4mzHT3eBbWuQwPTaNEOSMsaj/VbMPpH5e7AhO3DxFB9wIz.mZe', 'user'),
(21, 'Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2b$12$uIUZY5cWsKIHlYGN0BN64.B37M3UBNXhW872wngRFWcSeEBI0as3G', 'user');

-- Données trajet
INSERT INTO `trajet` (`id_trajet`, `id_agence_depart`, `id_agence_arrivee`, `date_heure_depart`, `date_heure_arrivee`, `nb_places_total`, `nb_places_dispo`, `id_contact`, `id_createur`) VALUES
(6, 3, 5, '2025-07-30 01:24:00', '2025-08-01 03:26:00', 3, 3, 2, 2),
(9, 14, 6, '2025-08-30 21:30:00', '2025-08-31 20:30:00', 4, 4, 1, 1),
(11, 6, 7, '2025-08-27 19:56:00', '2025-08-28 23:59:00', 11, 11, 3, 3),
(12, 12, 11, '2025-08-22 22:40:00', '2025-08-30 21:40:00', 2, 2, 2, 2),
(16, 6, 12, '2025-08-28 20:55:00', '2025-08-29 20:50:00', 2, 2, 2, 2),
(17, 10, 6, '2025-09-03 16:50:00', '2025-09-03 20:55:00', 3, 3, 1, 1),
(18, 17, 20, '2025-08-29 20:30:00', '2025-08-30 23:30:00', 5, 5, 3, 3);

-- Remise à jour des AUTO_INCREMENT
ALTER TABLE `agence` AUTO_INCREMENT=24;
ALTER TABLE `utilisateur` AUTO_INCREMENT=22;
ALTER TABLE `trajet` AUTO_INCREMENT=19;
