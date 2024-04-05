INSERT INTO
    `tpa_roles` (`role_code`, `role_name`)
VALUES
    ('100', 'webmaster'),
    ('90', 'admin'),
    ('20', 'utilisateur'),
    ('10', 'inscrit');

INSERT INTO
    `tpa_users` (
        `user_id`,
        `email`,
        `lastname`,
        `firstname`,
        `user_password`,
        `roles_code`
    )
VALUES
    (
        '1',
        'emploi@corbisier.fr',
        'CORBISIER',
        'Eric',
        '1234',
        '100'
    );