USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
insDoc(aux1, gLnk("S","Akcesoria do porcelany","/go/_category/?idc=%2241_12161%22"))
insDoc(aux1, gLnk("S","Kleje","/go/_category/?idc=%2241_12216%22"))
insDoc(aux1, gLnk("S","Lakiery dystansowe","/go/_category/?idc=%2241_12193%22"))
insDoc(aux1, gLnk("S","Piny , retencje","/go/_category/?idc=%2241_12158%22"))
insDoc(aux1, gLnk("S","Preparaty do gipsu , wosku","/go/_category/?idc=%2241_12183%22"))
insDoc(aux1, gLnk("S","Urz±dzenia","/go/_category/?idc=%2241_12211%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2241_12171%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2241_12171_156%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2241_12171_159%22"))
