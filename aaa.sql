CREATE TABLE employe(
CodeE Number(4) not null AUTO_INCREMENT primary key,
NomFr varchar2(30),
NomAr varchar2(30),
PrenomFR varchar2(40),
PrenomAr varchar2(40),
DateN date,
LieuNFr varchar2(20),
LieuNAr varchar2(20),

)

CREATE TABLE marie(
idEmploye int not null primary key,
nbrEnf int,
constraint FK1 foreign key (idEmploye) references employe(idEmploye)
);

CREATE TABLE Fmarie(
idEmploye int not null primary key,
NomM varchar(40),
constraint FK1 foreign key (idEmploye) references employe(idEmploye)
)



CREATE TABLE users(
codeU Number(4) not null AUTO_INCREMENT primary key,
NomU varchar2(30) not null,
MotDePasse varchar2(30) not null,
Permission Number(1) not null default(1)
);

CREATE TABLE document(
)


CREATE TABLE Conge(
codeCg int not null AUTO_INCREMENT primary key,
dateDeb date not null,
dateFin date not null,
type int,
CodeE int not null,
constraint FK32 foreign key (CodeE) references employe(idEmploye)
);

CREATE TABLE Abscence(
codeAb int not null AUTO_INCREMENT primary key,
dateAbs date not null,
CodeE int not null,
constraint FK31 foreign key (CodeE) references employe(idEmploye)
)