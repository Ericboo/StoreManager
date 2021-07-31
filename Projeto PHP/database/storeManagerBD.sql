--
-- PostgreSQL database dump
--

-- Dumped from database version 13.2
-- Dumped by pg_dump version 13.2

-- Started on 2021-04-26 20:31:21

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 200 (class 1259 OID 24581)
-- Name: Estabelecimento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Estabelecimento" (
    nome character varying(128) NOT NULL,
    cnpj character varying(32) NOT NULL,
    lim_pessoas integer NOT NULL,
    max_funcionarios integer NOT NULL,
    max_clientes integer NOT NULL,
    lim_acompanhantes integer,
    hora_abertura time(2) without time zone NOT NULL,
    hora_fechamento time(2) without time zone NOT NULL
);


ALTER TABLE public."Estabelecimento" OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 24586)
-- Name: cadastro; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cadastro (
    nome character varying(128) NOT NULL,
    idade integer NOT NULL,
    endereco character varying(128) NOT NULL,
    entrada timestamp(2) without time zone NOT NULL,
    telefone character varying(32),
    saida timestamp(2) without time zone NOT NULL,
    username character varying,
    senha character varying,
    id integer NOT NULL
);


ALTER TABLE public.cadastro OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 24613)
-- Name: cliente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cliente (
    num_acompanhantes integer NOT NULL,
    est_cadastrado character varying,
    id integer NOT NULL
);


ALTER TABLE public.cliente OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 24605)
-- Name: funcionario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.funcionario (
    cargo character varying(32) NOT NULL,
    adm integer,
    id integer NOT NULL
);


ALTER TABLE public.funcionario OWNER TO postgres;

--
-- TOC entry 2999 (class 0 OID 24581)
-- Dependencies: 200
-- Data for Name: Estabelecimento; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Estabelecimento" (nome, cnpj, lim_pessoas, max_funcionarios, max_clientes, lim_acompanhantes, hora_abertura, hora_fechamento) FROM stdin;
Destilaria Pitú	88.567.412/5000-01	52	28	12	1	09:00:00	18:00:00
Padaria dos Sonhos	65.778.998/5666-54	204	4	40	4	07:30:00	21:00:00
Padaria Dois Irmãos	65.779.000/0000-04	306	6	60	4	07:30:00	21:00:00
Hipermercado Duda	12.988.545/5559-87	245	5	120	2	08:30:00	22:00:00
Farmácia Popular	66.776.665/5544-67	63	3	20	2	08:30:00	00:00:00
\.


--
-- TOC entry 3000 (class 0 OID 24586)
-- Dependencies: 201
-- Data for Name: cadastro; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cadastro (nome, idade, endereco, entrada, telefone, saida, username, senha, id) FROM stdin;
Eric Jonai Costa Souza	21	T21 Cj 36 Lt 01	1990-01-01 00:00:01	63981227183	1990-01-01 00:00:01	erig	8255	5676
Emanuel da Silva Souza	33	Jardim Taquari	1990-01-01 00:00:01	+5563981227183	1990-01-01 00:00:01	emanuel	1303	3321
Fernanda da Silva Pimentel	22	Rua dos Alfeneiros Nº 4	1990-01-01 00:00:01	63987226565	1990-01-01 00:00:01	fernanda	8255	858
Joel Freitas da Costa	25	Rua dos Alfeneiros Nº 4	2021-04-21 16:30:01	63987226565	2021-04-21 18:30:01	joFreitas	8255	3377
Jocélia Abraão Costa	56	Rua dos Alfeneiros Nº 77	2021-04-26 16:00:00	63987226565	2021-04-26 16:00:00	joce	joce123	3427
\.


--
-- TOC entry 3002 (class 0 OID 24613)
-- Dependencies: 203
-- Data for Name: cliente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cliente (num_acompanhantes, est_cadastrado, id) FROM stdin;
0	12.988.545/5559-87	3377
\.


--
-- TOC entry 3001 (class 0 OID 24605)
-- Dependencies: 202
-- Data for Name: funcionario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.funcionario (cargo, adm, id) FROM stdin;
Programador	1	5676
Gerente	1	858
Caixa	0	3427
\.


--
-- TOC entry 2864 (class 2606 OID 24585)
-- Name: Estabelecimento CNPJ_PK; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Estabelecimento"
    ADD CONSTRAINT "CNPJ_PK" PRIMARY KEY (cnpj);


--
-- TOC entry 2866 (class 2606 OID 49167)
-- Name: cadastro ID_PK; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cadastro
    ADD CONSTRAINT "ID_PK" PRIMARY KEY (id);


--
-- TOC entry 2868 (class 2606 OID 49168)
-- Name: cliente ID_FK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT "ID_FK" FOREIGN KEY (id) REFERENCES public.cadastro(id) NOT VALID;


--
-- TOC entry 2867 (class 2606 OID 49173)
-- Name: funcionario ID_FK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT "ID_FK" FOREIGN KEY (id) REFERENCES public.cadastro(id) NOT VALID;


-- Completed on 2021-04-26 20:31:21

--
-- PostgreSQL database dump complete
--

