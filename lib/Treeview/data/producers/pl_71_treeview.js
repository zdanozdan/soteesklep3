USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
insDoc(aux1, gLnk("S","Adapta","/go/_category/?idc=%2241_12174%22"))
insDoc(aux1, gLnk("S","Agar","/go/_category/?idc=%2241_12201%22"))
insDoc(aux1, gLnk("S","Gumki polerskie","/go/_category/?idc=%2241_12173%22"))
insDoc(aux1, gLnk("S","Kamienie , Tarcze , Separatory","/go/_category/?idc=%2241_12185%22"))
aux2 = insFld(aux1, gFld("Masy os³aniaj±ce","/go/_category/?idc=%2241_12178%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2241_12178_158%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2241_12178_157%22"))
aux2 = insFld(aux1, gFld("Metale","/go/_category/?idc=%2241_12177%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2241_12177_158%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2241_12177_157%22"))
insDoc(aux1, gLnk("S","P³yny do utwardzania modeli","/go/_category/?idc=%2241_12221%22"))
insDoc(aux1, gLnk("S","Preparaty do gipsu , wosku","/go/_category/?idc=%2241_12183%22"))
insDoc(aux1, gLnk("S","Szczotki , Filce","/go/_category/?idc=%2241_12181%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2241_12171%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2241_12171_156%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2241_12171_159%22"))
