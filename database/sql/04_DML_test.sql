-- Insérer les utilisateurs avec différents rôles
INSERT INTO
    `tpa_users` (
        `roles_id`, `email`, `lastname`, `firstname`, `user_password`
    )
VALUES (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@webmaster'
        ), 'ecorbisier.simplon@gmail.com', 'CORBISIER', 'Eric', 'Einstein2020@'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@webmaster'
        ), 'jean.dupont@example.com', 'Dupont', 'Jean', 'MotDePasse1'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@admin'
        ), 'marie.durand@example.com', 'Durand', 'Marie', 'MotDePasse2'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@user'
        ), 'pierre.martin@example.com', 'Martin', 'Pierre', 'MotDePasse3'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@registered'
        ), 'sophie.lefebvre@example.com', 'Lefebvre', 'Sophie', 'MotDePasse4'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@webmaster'
        ), 'michel.dubois@example.com', 'Dubois', 'Michel', 'MotDePasse5'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@admin'
        ), 'isabelle.roux@example.com', 'Roux', 'Isabelle', 'MotDePasse6'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@user'
        ), 'philippe.leclerc@example.com', 'Leclerc', 'Philippe', 'MotDePasse7'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@registered'
        ), 'sylvie.garcia@example.com', 'Garcia', 'Sylvie', 'MotDePasse8'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@webmaster'
        ), 'david.fournier@example.com', 'Fournier', 'David', 'MotDePasse9'
    ),
    (
        (
            SELECT id
            FROM tpa_roles
            WHERE
                role_code = 'role@admin'
        ), 'anne.legrand@example.com', 'Legrand', 'Anne', 'MotDePasse10'
    );

-- Générer 30 tâches réparties sur tous les utilisateurs
INSERT INTO
    `tpa_tasks` (
        `users_id`, `task_name`, `task_description`, `task_reminder`, `task_start_at`, `task_end_at`
    )
VALUES (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'jean.dupont@example.com'
        ), 'Réunion de projet', 'Réunion pour discuter de l\'avancement du projet X avec toute l\'équipe.', NULL, '2024-04-17 09:00:00', '2024-04-17 10:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'marie.durand@example.com'
        ), 'Présentation client', 'Préparer la présentation pour le client Y sur les nouvelles fonctionnalités.', NULL, '2024-04-18 14:00:00', '2024-04-18 16:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'pierre.martin@example.com'
        ), 'Analyse de données', 'Analyser les données de performance du dernier trimestre et préparer un rapport.', NULL, '2024-04-19 10:00:00', '2024-04-19 12:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'sophie.lefebvre@example.com'
        ), 'Révision des documents', 'Revoir et corriger les documents de spécifications pour le projet Z.', NULL, '2024-04-20 09:30:00', '2024-04-20 11:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'michel.dubois@example.com'
        ), 'Formation sur les nouvelles technologies', 'Participer à la formation sur les nouvelles technologies dans la salle de conférence.', NULL, '2024-04-21 13:00:00', '2024-04-21 16:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'isabelle.roux@example.com'
        ), 'Entretien annuel', 'Conduire l\'entretien annuel avec l\'équipe pour discuter des objectifs et des performances.', NULL, '2024-04-22 10:00:00', '2024-04-22 12:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'philippe.leclerc@example.com'
        ), 'Réunion marketing', 'Participer à la réunion du département marketing pour planifier la prochaine campagne publicitaire.', NULL, '2024-04-23 11:00:00', '2024-04-23 12:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'sylvie.garcia@example.com'
        ), 'Préparation du rapport trimestriel', 'Préparer le rapport trimestriel sur les ventes et les performances financières.', NULL, '2024-04-24 09:00:00', '2024-04-24 13:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'david.fournier@example.com'
        ), 'Tests d\'intégration', 'Effectuer des tests d\'intégration pour s\'assurer que les fonctionnalités nouvellement développées fonctionnent correctement ensemble.', NULL, '2024-04-25 14:00:00', '2024-04-25 17:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'anne.legrand@example.com'
        ), 'Formation sur la sécurité informatique', 'Assister à la formation sur les bonnes pratiques de sécurité informatique.', NULL, '2024-04-26 10:00:00', '2024-04-26 12:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'jean.dupont@example.com'
        ), 'Réunion d\'équipe', 'Réunion hebdomadaire de l\'équipe pour discuter des tâches en cours et des prochaines étapes.', NULL, '2024-04-27 09:30:00', '2024-04-27 11:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'marie.durand@example.com'
        ), 'Développement de nouvelles fonctionnalités', 'Développer de nouvelles fonctionnalités pour l\'application mobile.', NULL, '2024-04-28 10:00:00', '2024-04-28 15:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'pierre.martin@example.com'
        ), 'Réunion de planification', 'Réunion pour planifier les étapes suivantes du projet X.', NULL, '2024-04-29 14:00:00', '2024-04-29 16:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'sophie.lefebvre@example.com'
        ), 'Analyse de marché', 'Analyser les tendances du marché pour identifier de nouvelles opportunités commerciales.', NULL, '2024-04-30 11:00:00', '2024-04-30 13:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'michel.dubois@example.com'
        ), 'Préparation de la présentation', 'Préparer la présentation pour la conférence du mois prochain.', NULL, '2024-05-01 09:00:00', '2024-05-01 12:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'isabelle.roux@example.com'
        ), 'Réunion de suivi', 'Réunion de suivi avec l\'équipe pour évaluer les progrès du projet.', NULL, '2024-05-02 14:00:00', '2024-05-02 16:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'philippe.leclerc@example.com'
        ), 'Test utilisateur', 'Effectuer des tests d\'utilisateur pour obtenir des retours sur l\'interface utilisateur.', NULL, '2024-05-03 10:00:00', '2024-05-03 12:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'sylvie.garcia@example.com'
        ), 'Formation sur la gestion du temps', 'Assister à la formation sur la gestion efficace du temps.', NULL, '2024-05-04 09:30:00', '2024-05-04 11:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'david.fournier@example.com'
        ), 'Préparation du budget', 'Préparer le budget pour le prochain trimestre en collaboration avec l\'équipe financière.', NULL, '2024-05-05 13:00:00', '2024-05-05 15:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'anne.legrand@example.com'
        ), 'Réunion de revue', 'Réunion de revue pour discuter des leçons apprises et des améliorations pour les projets futurs.', NULL, '2024-05-06 11:00:00', '2024-05-06 12:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'jean.dupont@example.com'
        ), 'Préparation de la documentation', 'Préparer la documentation pour les nouvelles fonctionnalités développées.', NULL, '2024-05-07 09:00:00', '2024-05-07 12:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'marie.durand@example.com'
        ), 'Préparation de la démo', 'Préparer la démo pour le client afin de présenter les fonctionnalités finalisées.', NULL, '2024-05-08 10:00:00', '2024-05-08 13:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'pierre.martin@example.com'
        ), 'Réunion d\'évaluation', 'Réunion d\'évaluation pour discuter des performances individuelles et des opportunités de développement.', NULL, '2024-05-09 14:00:00', '2024-05-09 16:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'sophie.lefebvre@example.com'
        ), 'Préparation du plan de communication', 'Préparer le plan de communication pour la prochaine campagne de lancement de produit.', NULL, '2024-05-10 09:30:00', '2024-05-10 11:30:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'michel.dubois@example.com'
        ), 'Réunion avec le fournisseur', 'Réunion avec le fournisseur pour discuter des termes du contrat pour le nouvel équipement.', NULL, '2024-05-11 13:00:00', '2024-05-11 15:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'isabelle.roux@example.com'
        ), 'Réunion de planification stratégique', 'Réunion pour discuter de la stratégie d\'entreprise à long terme.', NULL, '2024-05-12 10:00:00', '2024-05-12 12:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'philippe.leclerc@example.com'
        ), 'Évaluation des outils de gestion de projet', 'Évaluer différents outils de gestion de projet pour améliorer l\'efficacité de l\'équipe.', NULL, '2024-05-13 11:00:00', '2024-05-13 13:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'sylvie.garcia@example.com'
        ), 'Préparation du rapport de fin de projet', 'Préparer le rapport de fin de projet pour le client en résumant les résultats et les réalisations.', NULL, '2024-05-14 09:00:00', '2024-05-14 12:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'david.fournier@example.com'
        ), 'Formation sur la gestion du stress', 'Assister à la formation sur la gestion du stress au travail.', NULL, '2024-05-15 13:00:00', '2024-05-15 15:00:00'
    ),
    (
        (
            SELECT id
            FROM tpa_users u
            WHERE
                u.email = 'anne.legrand@example.com'
        ), 'Réunion de clôture', 'Réunion de clôture pour célébrer la fin réussie du projet et remercier l\'équipe pour son travail.', NULL, '2024-05-16 10:00:00', '2024-05-16 12:30:00'
    );

-- Générer des sous-tâches pour chaque tâche existante
INSERT INTO
    `tpa_subtasks` (
        `tasks_id`, `subtask_name`, `subtask_order`, `subtask_is_finished`
    )
VALUES
    -- Tâche 1
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de projet'
                AND u.email = 'jean.dupont@example.com'
        ), 'Préparer l\'ordre du jour', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de projet'
                AND u.email = 'jean.dupont@example.com'
        ), 'Imprimer les documents nécessaires', 2, NULL
    ),
    -- Tâche 2
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Présentation client'
                AND u.email = 'marie.durand@example.com'
        ), 'Finaliser la présentation PowerPoint', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Présentation client'
                AND u.email = 'marie.durand@example.com'
        ), 'Extraire les données des sources', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Présentation client'
                AND u.email = 'marie.durand@example.com'
        ), 'Créer les graphiques pour le rapport', 2, NULL
    ),
    -- Tâche 4
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Révision des documents'
                AND u.email = 'sophie.lefebvre@example.com'
        ), 'Relire et corriger les erreurs de grammaire', 1, NULL
    ),
    -- Tâche 5
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Formation sur les nouvelles technologies'
                AND u.email = 'michel.dubois@example.com'
        ), 'Prendre des notes pendant la formation', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Formation sur les nouvelles technologies'
                AND u.email = 'michel.dubois@example.com'
        ), 'Poser des questions au formateur', 2, NULL
    ),
    -- Tâche 6
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Entretien annuel'
                AND u.email = 'isabelle.roux@example.com'
        ), 'Préparer les documents d\'évaluation', 1, NULL
    ),
    -- Tâche 7
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion marketing'
                AND u.email = 'philippe.leclerc@example.com'
        ), 'Préparer le matériel de présentation', 1, NULL
    ),
    -- Tâche 8
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation du rapport trimestriel'
                AND u.email = 'sylvie.garcia@example.com'
        ), 'Compiler les données de vente', 1, NULL
    ),
    -- Tâche 9
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Tests d\'intégration'
                AND u.email = 'david.fournier@example.com'
        ), 'Exécuter les scénarios de test', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Tests d\'intégration'
                AND u.email = 'david.fournier@example.com'
        ), 'Documenter les résultats des tests', 2, NULL
    ),
    -- Tâche 10
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Formation sur la sécurité informatique'
                AND u.email = 'anne.legrand@example.com'
        ), 'Passer l\'examen de fin de formation', 1, NULL
    ),
    -- Tâche 11
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion d\'équipe'
                AND u.email = 'jean.dupont@example.com'
        ), 'Préparer l\'agenda de la réunion', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion d\'équipe'
                AND u.email = 'jean.dupont@example.com'
        ), 'Implémenter la nouvelle fonctionnalité A', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion d\'équipe'
                AND u.email = 'jean.dupont@example.com'
        ), 'Préparer la liste des points à discuter', 1, NULL
    ),
    -- Tâche 14
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Analyse de marché'
                AND u.email = 'sophie.lefebvre@example.com'
        ), 'Recueillir des données sur les tendances actuelles', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Analyse de marché'
                AND u.email = 'sophie.lefebvre@example.com'
        ), 'Analyser les données collectées', 2, NULL
    ),
    -- Tâche 15
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation de la présentation'
                AND u.email = 'michel.dubois@example.com'
        ), 'Créer les diapositives de la présentation', 1, NULL
    ),
    -- Tâche 16
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de suivi'
                AND u.email = 'isabelle.roux@example.com'
        ), 'Préparer le rapport d\'évaluation', 1, NULL
    ),
    -- Tâche 17
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Test utilisateur'
                AND u.email = 'philippe.leclerc@example.com'
        ), 'Créer les scénarios de test', 1, NULL
    ),
    -- Tâche 18
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Formation sur la gestion du temps'
                AND u.email = 'sylvie.garcia@example.com'
        ), 'Participer à l\'atelier sur la gestion des priorités', 1, NULL
    ),
    -- Tâche 19
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation du budget'
                AND u.email = 'david.fournier@example.com'
        ), 'Collecter les estimations de coûts', 1, NULL
    ),
    -- Tâche 20
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de revue'
                AND u.email = 'anne.legrand@example.com'
        ), 'Préparer les questions pour la revue', 1, NULL
    ),
    -- Tâche 21
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation de la documentation'
                AND u.email = 'jean.dupont@example.com'
        ), 'Créer les fichiers de documentation', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation de la documentation'
                AND u.email = 'jean.dupont@example.com'
        ), 'Préparer les démonstrations de fonctionnalités', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation de la documentation'
                AND u.email = 'jean.dupont@example.com'
        ), 'Préparer les critères d\'évaluation', 1, NULL
    ),
    -- Tâche 24
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation du plan de communication'
                AND u.email = 'sophie.lefebvre@example.com'
        ), 'Définir les canaux de communication', 1, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Préparation du plan de communication'
                AND u.email = 'sophie.lefebvre@example.com'
        ), 'Préparer la liste des questions pour le fournisseur', 1, NULL
    ),
    -- Tâche 26
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de planification stratégique'
                AND u.email = 'isabelle.roux@example.com'
        ), 'Préparer les objectifs à discuter', 1, NULL
    ),
    -- Tâche 27
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Évaluation des outils de gestion de projet'
                AND u.email = 'philippe.leclerc@example.com'
        ), 'Rechercher des alternatives d\'outils', 1, NULL
    ),
    -- Tâche 30
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de clôture'
                AND u.email = 'anne.legrand@example.com'
        ), 'Résumer les réalisations clés du projet', 2, NULL
    ),
    -- Tâche 30
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de clôture'
                AND u.email = 'anne.legrand@example.com'
        ), 'Participer aux exercices de relaxation', 3, NULL
    ),
    (
        (
            SELECT t.id
            FROM tpa_tasks t
                JOIN tpa_users u ON t.users_id = u.id
            WHERE
                t.task_name = 'Réunion de clôture'
                AND u.email = 'anne.legrand@example.com'
        ), 'Préparer les remerciements pour l\'équipe', 1, NULL
    );