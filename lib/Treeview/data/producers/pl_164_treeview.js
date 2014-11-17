USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_54%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
insDoc(aux1, gLnk("S","Akryle","/go/_category/?idc=%2250_12270%22"))
insDoc(aux1, gLnk("S","Akryle do licowania","/go/_category/?idc=%2250_12332%22"))
insDoc(aux1, gLnk("S","Kolorniki","/go/_category/?idc=%2250_12274%22"))
insDoc(aux1, gLnk("S","Szczotki , Filce","/go/_category/?idc=%2250_12295%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2250_12285%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2250_12261%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2250_12261_256%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2250_12261_257%22"))
