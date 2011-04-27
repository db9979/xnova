<?php

// ----------------------------------------------------------------------------------------------------------
// Interface !
$lang['nfo_page_title']  = "Informa��o";
$lang['nfo_title_head']  = "Informa��o relativa";
$lang['nfo_name']        = "Nome";
$lang['nfo_destroy']     = "Destruir";
$lang['nfo_level']       = "N�vel";
$lang['nfo_range']       = "Alcance";
$lang['nfo_used_energy'] = "Consumo de energia";
$lang['nfo_used_deuter'] = "Consumo de deut�rio";
$lang['nfo_prod_energy'] = "Produ��o de energia";
$lang['nfo_difference']  = "Diferen�a";
$lang['nfo_prod_p_hour'] = "Produ��o por hora";
$lang['nfo_needed']      = "Necessita";
$lang['nfo_dest_durati'] = "Dura��o da destrui��o";

$lang['nfo_struct_pt']   = "Pontos de edif�cios";
$lang['nfo_shielf_pt']   = "Pontos de defesas";
$lang['nfo_attack_pt']   = "Valor do ataque";
$lang['nfo_rf_again']    = "RapidFire contra";
$lang['nfo_rf_from']     = "RapidFire de";
$lang['nfo_capacity']    = "Capacidade da frota";
$lang['nfo_units']       = "Unidades";
$lang['nfo_base_speed']  = "Velocidade base";
$lang['nfo_consumption'] = "Consumo de deut�rio";

// ----------------------------------------------------------------------------------------------------------
// Interface porte de saut
$lang['gate_start_moon'] = "Lua de partida";
$lang['gate_dest_moon']  = "Lua de destino:";
$lang['gate_use_gate']   = "Utilizar o portal de salto qu�ntico";
$lang['gate_ship_sel']   = "Sel�c��o da frota";
$lang['gate_ship_dispo'] = "dispon�vel";
$lang['gate_jump_btn']   = "Saltar";
$lang['gate_jump_done']  = "O salto foi efectuado com sucesso. Pr�ximo salto dispon�vel em: ";
$lang['gate_wait_dest']  = "Os carregadores de energia do portal de salto qu�ntico de destino ainda n�o recarregaram! Tempo de espera: ";
$lang['gate_no_dest_g']  = "N�o existe portal de salto qu�ntico no planeta de destino!";
$lang['gate_wait_star']  = "Os carregadores de energia do portal de salto qu�ntico de origem ainda n�o recarregaram! Tempo de espera: ";
$lang['gate_wait_data']  = "Erro: n�o existe portal de salto qu�ntico!";

// ----------------------------------------------------------------------------------------------------------
// Batiments Mines!
$lang['info'][1]['name']          = "Mina de Metal";
$lang['info'][1]['description']   = "As minas de metal constituem o principal produtor de mat�ria-prima para a constru��o de edif�cios e de naves espaciais. O metal � o material mais barato mas tamb�m o mais utilizado. A produ��o de metal necessita pouca energia. O metal encontra-se a grandes profundidades na maioria dos planetas. A evolu��o de uma mina de metal tornar� a mina maior, mais profunda, aumentando a produ��o.";
$lang['info'][2]['name']          = "Mina de Cristal";
$lang['info'][2]['description']   = "As minas de cristal constituem o principal produtor de mat�ria-prima para a elabora��o de circuitos el�ctricos e na estrutura dos componentes de ligas. A produ��o de cristal necessita o dobro da energia comparado com a produ��o de metal, assim o cristal � um material mais caro. Todos os edif�cios e naves espaciais utilizam cristal, infelizmente o cristal � raro e s� se encontra em grandes profundidades. Para aumentar a produ��o de cristal e assim obter cristais maiores e mais puros � indispens�vel evoluir as minas de cristal.";
$lang['info'][3]['name']          = "Extractor de Deut�rio";
$lang['info'][3]['description']   = "O deut�rio � �gua pesada - o n�cleo do hidrog�nio cont�m um neutr�o adicional, sendo um excelente combust�vel para as naves devido ao elevado rendimento energ�tico da reac��o. O deut�rio pode ser encontrado frequentemente no mar profundo devido ao seu peso molecular. Evoluir o extractor de deut�rio permite recolher maior quantidade deste recurso.";

// ----------------------------------------------------------------------------------------------------------
// Batiments Energie!
$lang['info'][4]['name']          = "Planta de Energia Solar";
$lang['info'][4]['description']   = "Para fornecer a energia necess�ria ao bom funcionamento das minas, s�o necess�rias grandes plantas de energia solar. A planta de energia solar � uma das maneiras para criar energia. A superf�cie das c�lulas fotovoltaicas, capazes de transformar a energia solar em energia el�ctrica, aumenta com a evolu��o da planta de energia solar. A planta de energia solar � uma estrutura indispens�vel para o estabelecimento e uso de energia num planeta.";
$lang['info'][12]['name']         = "Planta de Fus�o";
$lang['info'][12]['description']  = "Em plantas de fus�o, os n�cleos de hidrog�nio s�o fundidos em n�cleos de h�lio sobre uma enorme temperatura e press�o, libertando uma quantidade enorme de energia. Para cada grama de Deut�rio consumido, pode ser produzido at� 41,32*10^-13 joules de energia; Com 1g �s capaz de produzir 172MWh de energia.<br/><br/>Maiores reactores usam mais deut�rio e podem produzir mais energia por hora. O efeito da energia pode ser aumentado pesquisando a tecnologia de energia.<br/><br/>A produ��o de energia da planta de fus�o � calculada da seguinte forma:</br>30 * [N�vel da planta de fus�o] * (1,05 + [N�vel da tecnologia de energia] * 0,01) ^ [N�vel da planta de fus�o]";

// ----------------------------------------------------------------------------------------------------------
// Edif�cios normais!
$lang['info'][14]['name']         = "F�brica de Robots";
$lang['info'][14]['description']  = "A f�brica de robots fornece unidades baratas e competentes na constru��o que podem ser usadas para construir ou promover toda a estrutura planet�ria. Cada evolu��o para o n�vel superior desta f�brica aumenta a efici�ncia e o n�mero das unidades que ajudam e diminuem o tempo de constru��o.";
$lang['info'][15]['name']         = "F�brica de Nanites";
$lang['info'][15]['description']  = "Os nanites s�o unidades rob�ticas min�sculas com um tamanho m�dio apenas de alguns nan�metros. Estes micr�bios mec�nicos s�o ligados entre si e programados para uma tarefa da constru��o, oferecendo assim uma velocidade de constru��o �nica. Os nanites operam a n�vel molecular, cada evolu��o reduz para metade o tempo de constru��o dos edif�cios, das naves espaciais e das estruturas planet�rias de defesa.";
$lang['info'][21]['name']         = "Hangar";
$lang['info'][21]['description']  = "O hangar � respons�vel pela constru��o de naves espaciais e de sistemas de defesa. A evolu��o do hangar permite a produ��o de uma mais larga variedade de naves e de sistemas de defesa e a diminui��o do tempo de constru��o.";
$lang['info'][22]['name']         = "Armaz�m de Metal";
$lang['info'][22]['description']  = "Cada evolu��o do armaz�m de metal permite o aumento da capacidade de armazenamento. Se a capacidade m�xima do armaz�m � atingida, a produ��o de metal � interrompida.";
$lang['info'][23]['name']         = "Armaz�m de Cristal";
$lang['info'][23]['description']  = "Cada evolu��o do armaz�m de cristal permite o aumento da capacidade de armazenamento. Se a capacidade m�xima do armaz�m � atingida, a produ��o de cristal � interrompida.";
$lang['info'][24]['name']         = "Tanque de Deut�rio";
$lang['info'][24]['description']  = "Os tanques de deut�rio s�o tanques de armazenamento enormes. Estes tanques encontram-se frequentemente perto dos hangares planet�rios, sendo o deut�rio usado como combust�vel. Uma vez que a capacidade m�xima de tanque � atingida, a produ��o de deut�rio � interrompida.";
$lang['info'][31]['name']         = "Laborat�rio de Pesquisas";
$lang['info'][31]['description']  = "Para ser capaz de pesquisar e evoluir na �rea das tecnologias, � necess�ria a constru��o de um laborat�rio de pesquisas. A evolu��o do n�vel do laborat�rio aumenta a velocidade de aprendizagem das tecnologias, mas abre tamb�m ao ensino e pesquisa de novas tecnologias. De maneira a poder realizar a pesquisa o mais rapidamente poss�vel, os cient�ficos escolhem o planeta mais evolu�do e regressam depois ao planeta de origem com o conhecimento. De esta forma, � poss�vel introduzir as novas tecnologias em todos os planetas do imp�rio e oferece novas pesquisas.";
$lang['info'][33]['name']         = "Terra-Formador";
$lang['info'][33]['description']  = "O Terra-Formador permite aumentar o n�mero de �reas dispon�veis para constru��o do planeta. Gra�as a este processo, um planeta pode aumentar a sua capacidade, e espa�o. Com o tempo, o espa�o tende a ser insuficiente e v�rios m�todos j� utilizados eram insuficientes ou in�teis a longo prazo.<br/>Um grupo de cientistas e nano-tecnicos encontraram uma solu��o: Criar e formar Terra (Terra-Formador).<br/>Com muita energia, � possivel criar continentos inteiros!<br/>Nanitas especiais s�o produzidos neste edif�cio para assegurar a qualidade e a usabilidade das �reas formadas pelo Terra-Formador.";
$lang['info'][34]['name']         = "Dep�sito da Alian�a";
$lang['info'][34]['description']  = "O dep�sito da alian�a permite �s frotas da alian�a a possibilidade de reabastecer. Cada evolu��o do dep�sito fornece �s frotas em �rbita 10.000 unidades adicionais de deut�rio por hora.";

// ----------------------------------------------------------------------------------------------------------
// Edif�cios especiais!
$lang['info'][41]['name']         = "Base Lunar";
$lang['info'][41]['description']  = "Sabendo que uma lua n�o possui atmosfera, uma base lunar � necessaria para criar um espa�o habit�vel. A base lunar fornece oxigenio mas tamb�m gravita��o artificial, e prote��o. Cada evolu��o da base lunar aumenta o tamanho da �rea para constru��o de estruturas. Cada n�vel fornece 3 campos lunares, at� a lua estar cheia.";
$lang['info'][42]['name']         = "Sensor Phalanx";
$lang['info'][42]['description']  = "Um dispositivo de alta resolu��o do sensor � utilizado para espiar um espectro de frequ�ncia. As varia��es de energia mostram informa��es sobre o movimento de frotas. Para realizar uma varredura � necess�ria uma quantidade de energia sob forma de deut�rio dispon�vel na lua.";
$lang['info'][43]['name']         = "Portal de Salto Qu�ntico";
$lang['info'][43]['description']  = "O Portal de Salto Qu�ntico � um transceptor enorme capaz de transportar instantaneamente uma frota inteira para outro portal de salto. O transmissor n�o necessita de Deut�rio para funcionar, mas precisa de arrefecer durante 1 hora entre saltos. N�o � poss�vel transportar recursos pelo portal. Todo o equipamento � feito de tecnologia de ponta.";

$lang['info'][44]['name']         = "Silo de M�sseis";
$lang['info'][44]['description']  = "O silo de m�sseis � a estrutura de lan�amento e armazenamento dos m�sseis. Tem o espa�o para 5 m�sseis interplanet�rios ou 10 m�sseis de intercep��o por cada n�vel evolu�do.";

// ----------------------------------------------------------------------------------------------------------
// Laboratoire !
$lang['info'][106]['name']        = "Tecnologia de Espionagem";
$lang['info'][106]['description'] = "A tecnologia de espionagem resulta de pesquisas sobre sensores de dados, equipamento e conhecimento da intelig�ncia de que um imp�rio necessita para se proteger de ataques, mas tamb�m para dirigir ataques contra o inimigo. A evolu��o desta tecnologia aumenta os detalhes, e informa��es obtidos.<br/><br/>O resultado de espionagem depende tamb�m da for�a e do n�vel de espionagem do jogador adverso. A evolu��o do n�vel da tecnologia de espionagem define tamb�m o n�vel dos detalhes sobre uma frota que se aproxima do teu planeta:<br/>- N�vel 2 adiciona o n�mero de naves � informa��o sobre a frota;<br/>- N�vel 4 adiciona o tipo das naves que se aproximam;<br/>- N�vel 8 adiciona finalmente detalhes sobre o tipo e o n�mero de naves que se aproximam.</br><br/>Em geral, a tecnologia de espionagem � muito importante para um imp�rio, seja ele agressivo ou amig�vel. Conselho: come�ar a pesquisar esta �rea tecnol�gica logo depois de ter � sua disposi��o as primeiras naves de transporte.";
$lang['info'][108]['name']        = "Tecnologia de Computadores";
$lang['info'][108]['description'] = "A inform�tica � utilizada para construir processos de dados cada vez mais evolu�dos e controlar unidades. Cada evolu��o desta tecnologia aumenta o n�mero de frotas que podem ser comandadas em mesmo tempo. Aumentando esta tecnologia, permite mais actividade e assim um melhor rendimento, isso tomando em conta as frotas militares assim como transportes de carga e espionagem. Ser� uma boa ideia aumentar constantemente a pesquisa nesta �rea para fornecer uma flexibilidade adequada ao imp�rio.";
$lang['info'][109]['name']        = "Tecnologia de Armas";
$lang['info'][109]['description'] = "A tecnologia de armas trata do desenvolvimento dos sistemas de armas existentes. � focalizada principalmente no aumento do poder e da efici�ncia das armas.<br/>Com esta tecnologia, e aumentando o seu n�vel, a mesma arma tem mais poder e causa mais danos - cada n�vel aumenta o poder de fogo em 10%.<br/>A tecnologia de armas � importante permanecer a um n�vel elevado, para n�o facilitar a tarefa dos inimigos.";
$lang['info'][110]['name']        = "Tecnologia de Escudo";
$lang['info'][110]['description'] = "A tecnologia de escudo � utilizada para criar um escudo protector. Cada evolu��o do n�vel desta tecnologia aumenta a protec��o em 10%. O n�vel do melhoramento aumenta basicamente a quantidade de energia que o escudo pode absorver antes de ser destruido. Esta tecnologia n�o s� aumenta a qualidade dos escudos das naves, como tamb�m do escudo protector planet�rio.";
$lang['info'][111]['name']        = "Tecnologia de Blindagem";
$lang['info'][111]['description'] = "Para uma dada liga que provou ser eficaz, a estrutura molecular pode ser alterada de maneira a manipular o seu comportamento numa situa��o de combate e incorporar as realiza��es tecnol�gicas. Cada evolu��o do n�vel desta tecnologia aumenta a blindagem em 10%.";
$lang['info'][113]['name']        = "Tecnologia de Energia";
$lang['info'][113]['description'] = "A tecnologia da energia trata do conhecimento das fontes de energia, das solu��es de armazenamento e das tecnologias que fornecem o que � mais b�sico: Energia. S�o necess�rios determinados n�veis de evolu��o desta tecnologia para permitir o acesso a novas tecnologias que confiam no conhecimento da energia.";
$lang['info'][114]['name']        = "Tecnologia de Hiperespa�o";
$lang['info'][114]['description'] = "A tecnologia de hiperespa�o fornece o conhecimento para as viagens no hiperespa�o utilizadas por muitas naves de guerra. � uma nova e complicada esp�cie de tecnologia que requer um equipamento caro de laborat�rio e facilidades de testes.";
$lang['info'][115]['name']        = "Motor de Combust�o";
$lang['info'][115]['description'] = "Os motores de combust�o pertencem aos motores antigos e s�o baseados na repuls�o. As part�culas s�o aceleradas deixando o motor criar uma for�a repulsiva que move a nave no sentido oposto. A efici�ncia destes motores de combust�o � baixa, mas s�o baratos e de confian�a.<br/>Pesquisar e evoluir esta tecnologia aumenta a velocidade de combust�o dos motores e assim a velocidade das naves, cada evolu��o aumenta a velocidade em 10%. Esta tecnologia � de grande import�ncia para um imp�rio emergente, e deve ser pesquisado o mais cedo poss�vel.";
$lang['info'][117]['name']        = "Motor de Impuls�o";
$lang['info'][117]['description'] = "Uma grande parte de mat�ria repulsada resulta em restos e lixo, criados pela fus�o nuclear. Cada evolu��o desta tecnologia aumenta em 20% a velocidade das naves mais pesadas como o cruzador, bombardeiro, ca�a pesado e nave de coloniza��o. Os motores de impuls�o s�o um desenvolvimento adicional aos motores de combust�o, aumentam a efici�ncia e abaixam o consumo de combust�vel relativo � velocidade.";
$lang['info'][118]['name']        = "Motor Propulsor de Hiperespa�o";
$lang['info'][118]['description'] = "O motor propulsor � baseado na curvatura do espa�o-tempo. Desta maneira, o ambiente das naves que utilizam este motor propulsor comprime-se, permitindo que as naves percorram grandes dist�ncias em muito pouco tempo. A evolu��o do motor propulsor aumenta a velocidade de algumas naves em 30%. Requesitos: Tecnologia de Hiperespa�o (N�vel 3) Laborat�rio de Pesquisa (N�vel 7).";
$lang['info'][120]['name']        = "Tecnologia Laser";
$lang['info'][120]['description'] = "O laser (amplifica��o de luz pela emiss�o estimulada da radia��o) cria um raio intenso de luz, que concentra uma grande quantidade de energia. O laser tem v�rias �reas de aplica��o como os sistemas �pticos de computadores, e as armas com alto poder destructivo. O conhecimento desta tecnologia � fundamental para a investiga��o de novas armas.<br/>Requisitos: Laborat�rio de Pesquisas (N�vel 1) Tecnologia de Energia (N�vel 2).";
$lang['info'][121]['name']        = "Tecnologia de I�es";
$lang['info'][121]['description'] = "Ao acelerar i�es um raio letal � criado, e causa danos importantes aos objectos que atinge.";
$lang['info'][122]['name']        = "Tecnologia de Plasma";
$lang['info'][122]['description'] = "Tecnologia mais avan�ada que a tecnologia de i�es, em vez de acelerar i�es, acelera-se o plasma com um grande poder energ�tico, desta forma cria-se um raio que ocasiona danos enormes aos objectos que atinge.";
$lang['info'][123]['name']        = "Rede Intergal�ctica de Pesquisas";
$lang['info'][123]['description'] = "Os cientistas dos teus planetas podem comunicar uns com os outros gra�as a esta rede.<br/>No n�vel 0, ter�s apenas o benef�cio de ligar o sat�lite ao teu laborat�rio de pesquisas mais evolu�do. Com o n�vel 1, ligar�s os 2 laborat�rios mais evolu�dos. Cada n�vel acrescenta mais um laborat�rio. Desta maneira, as pesquisas ser�o efectuadas com a m�xima velocidade.";
$lang['info'][124]['name']        = "Tecnologia de Explora��o Espacial";
$lang['info'][124]['description'] = "A tecnologia de Explora��o Espacial inclui formas de pesquisa � dist�ncia e permite o uso de m�dulos de pesquisa nas naves, estes �ltimos s�o compostos por uma base de dados funcional num laborat�rio m�vel. Para assegurar a seguran�a destas naves durante situa��es de pesquisa extremas, o m�dulo cont�m o seu pr�prio sistema de energia que cria um poderoso campo de for�as � volta do m�dulo durante uma emerg�ncia.";
$lang['info'][199]['name']        = "Tecnologia de Gravita��o";
$lang['info'][199]['description'] = "Um gr�viton � uma part�cula elementar respons�vel pelos efeitos da gravita��o. Com o aceleramento de part�culas gravitacionais, um campo gravitacional artificial � criado com uma for�a atractiva que pode n�o s� destruir naves mas tamb�m luas inteiras. De maneira a produzir a quantidade necess�ria de part�culas de gravita��o, o planeta tem que poder criar uma quantidade maci�a de energia. Requisitos: Laborat�rio de Pesquisas (N�vel 12).";

// ----------------------------------------------------------------------------------------------------------
// Flotte !
$lang['info'][202]['name']        = "Cargueiro Pequeno";
$lang['info'][202]['description'] = "Estas naves s�o aproximadamente do tamanho de uma nave de combate, mas n�o s�o equipadas nem com motores nem com armamento de combate, para deixar mais espa�o para os recursos a transportar. O cargueiro pequeno pode transportar at� 5.000 unidades de recursos.<br/>A velocidade b�sica dos teus cargueiros pequenos � aumentada logo que a tecnologia de impuls�o n�vel 5 for pesquisada, j� que ficam equipados com motores de impuls�o.";
$lang['info'][203]['name']        = "Cargueiro Grande";
$lang['info'][203]['description'] = "Esta nave n�o deve atacar sozinha, pois a sua estrutura n�o lhe permite resistrir muito tempo aos sistemas de defesa. O seu motor de combust�o altamente sofisticado permite-lhe ser um fornecedor r�pido do recursos. Normalmente, acompanha as frotas em invas�es a planetas para capturar e roubar recursos ao inimigo.";
$lang['info'][204]['name']        = "Ca�a Ligeiro";
$lang['info'][204]['description'] = "Considerando a sua estrutura, agilidade e alta velocidade, o ca�a ligeiro pode ser definido como uma boa arma no principio do jogo, e um bom acompanhante para as naves mais sofisticadas e poderosas.";
$lang['info'][205]['name']        = "Ca�a Pesado";
$lang['info'][205]['description'] = "Durante a evolu��o do ca�a ligeiro os investigadores chegaram ao ponto onde a tecnologia convencional alcan�a os seus limites. De maneira a fornecer agilidade ao novo ca�a, um poderoso motor de impuls�o foi usado pela primeira vez. Apesar dos custos e da complexidade adicionais, novas possibilidades tornaram-se dispon�veis. Com o uso da tecnologia de impuls�o e a integridade estrutural aumentada, foi poss�vel dar ao ca�a pesado um sistema de armas e uma resist�ncia necessitando mais energia transformando a nave numa verdadeira amea�a para o inimigo.";
$lang['info'][206]['name']        = "Cruzador";
$lang['info'][206]['description'] = "Com os lasers pesados e os canh�es do i�es que emergem nos campos de batalha, as naves b�sicas de combate encontravam cada vez mais em dificuldade. Apesar de muitas modifica��es nos sistemas de arma estas naves n�o podiam ser aumentadas ou evoluidas bastante para poder rivalizar com os novos sistemas de defesa.<br/>Por esta raz�o, foi decidido desenvolver uma nova nave, poderosa e com sistemas de armas devastadores. Nasceu ent�o o cruzador.<br/>Os cruzadores possuem um sistema de armas tr�s vezes mais poderoso do que aquele encontrado no ca�a pesado e uma velocidade de tiro aumentada. A velocidade do cruzador � a mais r�pida j� vista. Infelizmente, com o aparecimento mais tarde dos novos e mais fortes sistemas de defesa como os canh�es de Gauss e os lan�adores de plasma, o dom�nio dos cruzadores acabou. O cruzador tem RapidFire(10) contra os lan�adores de m�sseis e contra os ca�as ligeiros, isso quer dizer que um cruzador destr�i sempre mais de um m�ssil ou ca�a ligeiro a cada round.";
$lang['info'][207]['name']        = "Nave de Batalha";
$lang['info'][207]['description'] = "As naves de batalha constituem a espinha dorsal de qualquer frota militar. Os sistemas de armas poderosos e a resist�ncia inigual�vel da nave de batalha adicionados � alta velocidade e � capacidade de carga importante fazem desta nave um perigo constante, em qualquer situa��o e contra qualquer oponente.";
$lang['info'][208]['name']        = "Nave de Coloniza��o";
$lang['info'][208]['description'] = "Esta nave permite colonizar novos planetas, outros mundos, onde nenhum homem ainda se aventurou no passado. Um imp�rio pode possuir at� 8 col�nias. As naves de coloniza��o t�m dupla utiliza��o. Podem servir como cargueiros (n�o recomendado pela sua lentid�o), e como naves de coloniza��o. Se pretendes colonizar um planeta, n�o envies recursos com a nave de coloniza��o, pois estes ser�o perdidos.";
$lang['info'][209]['name']        = "Reciclador";
$lang['info'][209]['description'] = "Os combates no espa�o parecem tornar-se cada vez mais impressionantes onde numa �nica batalha milhares de naves podem ser destru�das, e os restos perdidos para sempre. Os cargueiros n�o t�m os meios para recolher esses recursos valiosos.<br/>Com o desenvolvimento das naves espaciais, veio a ser poss�vel recolher aqueles campos de ru�nas. Um reciclador � do tamanho de um cargueiro grande e tem uma capacidade de armazenamento limitada de 20.000 unidades.";
$lang['info'][210]['name']        = "Sonda de Espionagem";
$lang['info'][210]['description'] = "As sondas de espionagem s�o drones com uma rapidez impressionante de propuls�o utilizados para espiar os inimigos. Com um sistema de comunica��o altamente avan�ado as sondas podem emitir dados a grande dist�ncia.<br/>Quando chegam ao planeta alvo, as sondas permanecem na orbita de maneira a recolher os dados do planeta. Durante esse per�odo � relativamente f�cil detect�-las. Uma vez detectadas, devido � fraqueza da sua estrutura, as sondas n�o podem resistir muito tempo aos tiros dos sistemas de defesa, e s�o rapidamente destruidas.<br/>Para que o tempo de permanencia em �rbita seja o mais reduzido poss�vel, � conveniente ter uma Tecnologia de Espionagem bem desenvolvida.";
$lang['info'][211]['name']        = "Bombardeiro";
$lang['info'][211]['description'] = "O bombardeiro � uma nave espacial desenvolvida para destruir os sistemas de defesa planet�rios mais recentes e poderosos. Dotado de um sistema de escolha de alvo guiado ao laser, e de bombas de plasma, o bombardeiro � uma arma destrutiva.<br/>A velocidade b�sica dos teus bombardeiros � aumentada assim que seja pesquisado o motor de hiperespa�o n�vel 8, j� que ficam equipadas com o motor de hiperespa�o.";
$lang['info'][212]['name']        = "Sat�lite Solar";
$lang['info'][212]['description'] = "Os sat�lites solares s�o sat�lites simples situados na �rbita de um planeta, equipados de c�lulas fotovoltaicas, capazes de transferir energia para o planeta. A energia � transmitida ao planeta gra�as a um feixe de laser especial.<br/>Estes sat�lites s�o uma ajuda ao n�vel da procura de energia, mas n�o resistem aos tiros das naves inimigas, e desta maneira a perda de os sat�lites pode ser fatal para a sobreviv�ncia energ�tica do teu planeta.";
$lang['info'][213]['name']        = "Destruidor";
$lang['info'][213]['description'] = "Com o destruidor, a m�e de todas as naves entra na arena. O sistema de armas desta nave � constitu�do por canh�es de ion-plasma e canh�es de Gauss, adicionando um sistema de detec��o e escolha de alvo, a nave pode destruir ca�as ligeiros voando em plena velocidade com 99% de probabilidade. A agilidade deste monstro de guerra � evidentemente embora a velocidade seja um grande ponto negativo, mas o destruidor pode ser considerado mais como uma esta��o de combate do que uma nave, com uma capacidade de transporte importante, acompanha as naves de batalha e d� uma ajudinha decisiva.";
$lang['info'][214]['name']        = "Estrela da Morte";
$lang['info'][214]['description'] = "Uma embarca��o deste tamanho e deste poder necessita uma quantidade gigantesca de recursos e m�o de obra que podem ser fornecidos somente pelos imp�rios mais importantes de todo o universo.";
$lang['info'][215]['name']        = "Interceptor";
$lang['info'][215]['description'] = "Esta nave, uma filigrana tecnol�gica, � mortal na altura de destruir frotas inimigas. Com os seus canh�es de laser aperfei�oados, mant�m uma posi��o privilegiada entre as naves pesadas, onde pode destruir bastantes em menos de nada. Devido ao seu pequeno design e ao seu enorme poderio de armas, a capacidade de carga � m�nima, mas isto � compensado com um consumo baixo de combust�vel do motor de hiperespa�o embutido.";

// ----------------------------------------------------------------------------------------------------------
// Defenses !
$lang['info'][401]['name']        = "Lan�ador de M�sseis";
$lang['info'][401]['description'] = "O lan�ador de m�sseis � um sistema de defesa simples e barato. Tornam-se muito eficazes em n�mero e podem ser constru�dos sem pesquisa espec�fica porque � uma arma de bal�stica simples. Os custos de fabrica��o baixos fazem desta arma defensiva um advers�rio apropriado para frotas pequenas.<br/>Em geral, os sistemas de defesa desactivam-se ao alcan�ar par�metros operacionais cr�ticos de maneira a fornecer uma possibilidade de repara��o. 70% da defesa planet�ria destru�da pode ser reparada depois dum combate.";
$lang['info'][402]['name']        = "Laser Ligeiro";
$lang['info'][402]['description'] = "Para acompanhar o ritmo com a velocidade sempre crescente do desenvolvimento das tecnologias de naves espaciais, os cientistas tiveram que criar um tipo novo de sistema da defesa capaz de destru�r as naves mais fortes.<br/>Rapidamente, o laser ligeiro foi inventado, este pode disparar um feixe de laser altamente concentrado no alvo e criar danos muito mais elevados do que o impacto de m�sseis bal�sticos. Um pre�o baixo da unidade era um objetivo essencial do projeto, por isso a estrutura basica n�o foi melhorada comparada ao lan�ador de m�sseis.";
$lang['info'][403]['name']        = "Laser Pesado";
$lang['info'][403]['description'] = "O laser pesado � uma evolu��o directa do laser ligeiro, a integridade estrutural foi evolu�da e aumentada e materiais novos foram adoptados. Com os novos sistemas de energia e novos computadores, muito mais energia pode ser utilizada e dirigida para disparar fogo sobre o inimigo.";
$lang['info'][404]['name']        = "Canh�o de Gauss";
$lang['info'][404]['description'] = "Durante muito tempo pensou-se que as armas de proj�cteis iam ser como a tecnologia de fus�o e de energia, o desenvolvimento da propuls�o de hiperespa�o e o desenvolvimento de protec��es melhoradas ficando antigas at� que a tecnologia de energia, que a tinha posta de lado naquele tempo, as fez renascer. O princ�pio j� era conhecido no s�culo XX - o princ�pio de acelera��o de part�culas. Um canh�o de gauss (canh�o eletromagn�tico) n�o � nada mais que um acelerador de part�culas, onde os proj�cteis com um peso de v�rias toneladas come�am a ser acelerados. Mesmo as protec��es modernas, a blindagem ou os escudos t�m dificuldades em resistir a esta for�a, acabando um proj�ctil por atravessar completamente o objecto. Os sistemas de defesa desactivam-se quando est�o demasiado estragados. Depois de uma batalha, 70% dos sistemas danificados podem ser reparados.";
$lang['info'][405]['name']        = "Canh�o de I�es";
$lang['info'][405]['description'] = "No s�culo XXI existiu algo com o nome de PEM. O PEM era um pulso eletromagn�tico que causava uma tens�o adicional em cada circuito, o que provocava muitos incidentes de obstru��o nos instrumentos mais sens�veis. O PEM foi baseado em m�sseis e bombas, e tamb�m em rela��o �s bombas at�micas. O PEM foi depois evolu�do para fazer objectos incapazes de agir sem serem destruidos. Hoje, o canh�o de i�es � a vers�o mais moderna do PEM que lan�a uma onda de i�es contra um objecto (naves), destabilizando-lhe desta maneira as protec��es e a electr�nica. A for�a cin�tica n�o � significativa. Os cruzadores tamb�m utilizam esta tecnologia. � interessante n�o destruir uma embarca��o mas paraliz�-la. Depois de uma batalha 70% dos sistemas danificados podem ser reparados.";
$lang['info'][406]['name']        = "Canh�o de Plasma";
$lang['info'][406]['description'] = "A tecnologia de laser foi melhorada, a tecnologia de i�es alcan�ou a sua fase final. Pensou-se que seria imposs�vel criar sistemas de armas mais eficazes. A possibilidade de combinar os dois sistemas mudou este pensamento. Sabia-se j� que a tecnologia de fus�o, das part�culas dos lasers (geralmente deut�rio) faz aumentar a temperatura at� milh�es de graus. A tecnologia de i�es permite o carregamento el�trico das part�culas, a liga��o em redes de estabilidade e a acelera��o das part�culas. Assim nasce o plasma. A esfera de plasma � azul e visualmente atractiva, mas � dif�cil pensar que um grupo de embarca��es fique muito feliz de a ver. O canh�o de plasma � uma das armas mais poderosas, embora seja uma tecnologia � muito cara. Depois de uma batalha, 70% dos sistemas danificados podem ser reparados.";
$lang['info'][407]['name']        = "Pequeno Escudo Planet�rio";
$lang['info'][407]['description'] = "Muito tempo antes da instala��o dos escudos em embarca��es, os geradores j� existiam na superf�cie dos planetas. Cobriam os planetas e eram capazes de absorver quantidades enormes de danos antes de serem destru�dos. Os ataques com frotas ligeiras falhavam frequentemente quando se encontravam com estes geradores. Mais tarde, foi imaginado a cria��o de um enorme escudo planet�rio. Para cada planeta um escudo planet�rio.";
$lang['info'][408]['name']        = "Grande Escudo Planet�rio";
$lang['info'][408]['description'] = "O grande escudo planet�rio cobre o planeta para absorver quantidades enormes de tiros. A sua resist�ncia � muito maior daquela encontrada no pequeno escudo planet�rio e francamente resistente contra o RapidFire das naves de combate.";

// ----------------------------------------------------------------------------------------------------------
// Missiles !
$lang['info'][502]['name']        = "M�ssil de Intercep��o";
$lang['info'][502]['description'] = "O m�ssil de intercep��o destr�i os m�sseis interplanet�rios atacantes. Cada m�ssil de intercep��o pode destruir um m�ssil interplanet�rio lan�ado em ataque.";
$lang['info'][503]['name']        = "M�ssil Interplanet�rio";
$lang['info'][503]['description'] = "O m�ssil interplanet�rio destr�i os sistemas de defesa do inimigo. Os sistemas destruidos desta maneira n�o podem ser reparados.";

// ----------------------------------------------------------------------------------------------------------
// Officiers !
$lang['info'][601]['name']        = "Ge�logo";
$lang['info'][601]['description'] = "O Ge�logo � um experiente astromineralogista e cristalografista. Ele assiste as suas equipas de metalurgia e qu�mica e cuida das comunica��es interplanet�rias optimizando o seu uso e a refina��o das mat�rias-primas por todo o imp�rio<br /><br /><font color=\"red\">+5% da produ��o.<br /> N�vel m�x. : 20</font>";
$lang['info'][602]['name']        = "Almirante";
$lang['info'][602]['description'] = "O Almirante de frota � um experiente veterano de guerra e um estratega. Nos combates mais dif�ceis, ele � capaz de definir uma estrat�gia e transmiti-la aos seus subordinados. Um s�bio imperador pode confiar no seu suporte em batalhas e poder� adicionar mais slots de frota para o combate.<br /><br /><font color=\"red\">+5% de defesa, protec��o de frota e armamento na frota.<br /> N�vel Max.: 20</font>";
$lang['info'][603]['name']        = "Engenheiro";
$lang['info'][603]['description'] = "O engenheiro � especialista na gest�o de energia. Em �pocas de paz, aumenta a energia de todas as tuas col�nias. Em caso de ataque, assegura a fonte de energia aos canh�es defensivos evitando uma eventual sobrecarga, reduzindo deste modo as perdas na batalha.<br /><br /><font color=\"red\">+5% de energia.<br /> N�vel Max.: 10</font>";
$lang['info'][604]['name']        = "Tecnocrata";
$lang['info'][604]['description'] = "Os tecnocratas s�o cientistas geniais. Eles s�o encontrados em �reas onde a tecnologia est� prestes a atingir os seus limites. Ningu�m consegue decifrar a criptografia de um tecnocrata e a sua simples presen�a inspira investigadores em todo o imp�rio.<br /><br /><font color=\"red\">-5% de tempo de constru��o em toda a frota.<br /> N�vel Max : 10</font>";
$lang['info'][605]['name']        = "Construtor";
$lang['info'][605]['description'] = "O fabricante � um novo tipo de construtor. O seu DNA foi modificado para lhe dar uma for�a extraordin�ria. Apenas um desses \"homem\" pode construir uma cidade inteira.<br /><br /><font color=\"red\">-10% de tempo de constru��o.<br /> N�vel Max.: 3</font>";
$lang['info'][606]['name']        = "Cientista";
$lang['info'][606]['description'] = "A Ordem dos cientistas � composta por grandes g�nios. Podes encontr�-los sempre a discutir quest�es que desafiariam a l�gica de qualquer pessoa. Nenhuma pessoa normal conseguir� descobrir o c�digo desta ordem e � a sua presen�a que inspira todos investigadores no Imp�rio a conseguir mais e melhor.<br /><br /><font color=\"red\">-10% de tempo nas pesquisas.<br /> N�vel Max.: 3</font>";
$lang['info'][607]['name']        = "Armazenista";
$lang['info'][607]['description'] = "O armazenista fez parte da antiga Irmandade do planeta Hsac. O seu lema � ganhar o m�ximo, mas, por esta raz�o, necessita de espa�o de armazenamento. � por isso que o fabricante desenvolveu uma nova t�cnica de armazenamento.<br /><br /><font color=\"red\">+50% de armazenamento.<br /> N�vel Max.: 2</font>";
$lang['info'][608]['name']        = "Defensor";
$lang['info'][608]['description'] = "O defensor � um membro do ex�rcito imperial. O seu zelo pelo trabalho permite-lhe construir uma formid�vel defesa, num curto espa�o de tempo nas col�nias hostis.<br /><br /><font color=\"red\">-50% de tempo de constru��o das defesas.</font>";
$lang['info'][609]['name']        = "Bunker";
$lang['info'][609]['description'] = "O imperador tem notado o impressionante trabalho que tem prestado ao seu imp�rio. Para agradecer-lhe da-lhe a hip�tese de se tornar Bunker. Ser Bunker � o maior pr�mio da Minera��o do ex�rcito imperial.<br /><br /><font color=\"red\">Limpar o protector planet�rio</font> ";
$lang['info'][610]['name']        = "Espi�o";
$lang['info'][610]['description'] = "O espi�o � uma pessoa enigm�tica. Ningu�m viu o seu verdadeiro rosto, a menos que j� tivesse morto.<br /><br />+5 de<br /> N�vel de espionagem.<br /> N�vel Max.: 2<font color=\"red\"></font>";
$lang['info'][611]['name']        = "Comandante";
$lang['info'][611]['description'] = "O comandante do ex�rcito imperial domina a arte de lidar com frotas. O seu c�rebro pode calcular as trajet�rias de v�rias frotas, muito acima de um normal humano.<br /><br />+3 slots de frota.<br /> N�vel Max.: 3<font color=\"red\"></font> ";
$lang['info'][612]['name']        = "Destruidor";
$lang['info'][612]['description'] = "O Destruidor � um funcion�rio sem miseric�rdia. Ele massacra todo o planeta apenas por prazer. Est� actualmente a desenvolver um novo m�todo de produ��o de estrelas da morte<br /><br />2 EDM construidas ao inv�s de uma.<br /> N�vel Max.: 1<font color=\"red\"></font>";
$lang['info'][613]['name']        = "General";
$lang['info'][613]['description'] = "O General � uma pessoa que tem servido muitos anos no ex�rcito. O fabricante de navios produz mais r�pido na sua presen�a.<br /><br />+25% de velocidade no fabrico de frota.<br /> N�vel Max.: 3<font color=\"red\"></font>";
$lang['info'][614]['name']        = "Rigidez";
$lang['info'][614]['description'] = "O imperador detectou-lhe qualidades ineg�veis de conquista. Prop�e que se torne Rigido. A Rigidez � grau mais elevado do ramo das rigidezes do ex�rcito imperial<br /><br />Desbloquear a SuperNova<font color=\"red\"></font>";
$lang['info'][615]['name']        = "Emperador";
$lang['info'][615]['description'] = "Voc� tem mostrado que � o maior conquistador do universo. Este lugar deve ser seu.<br /><br />Desbloquear o destruidor planet�rio<font color=\"red\"></font>";

?>