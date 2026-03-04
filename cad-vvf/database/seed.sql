USE cad_vvf;

INSERT INTO protocols (name, description) VALUES ('Emergenza VVF Demo', 'Protocollo demo FPDS-like');

INSERT INTO questions (protocol_id, text, next_if_yes, next_if_no) VALUES
(1, 'Ci sono persone in pericolo?', 2, 3),
(1, 'Ci sono feriti gravi?', NULL, NULL),
(1, 'Ci sono fiamme visibili?', 4, 5),
(1, 'L\'incendio è contenuto?', NULL, NULL),
(1, 'Fine protocollo', NULL, NULL);