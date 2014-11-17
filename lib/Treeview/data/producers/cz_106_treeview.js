USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_45%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
insDoc(aux1, gLnk("S","Akryle","/go/_category/?idc=%2241_12157%22"))
insDoc(aux1, gLnk("S","Akryle do licowania","/go/_category/?idc=%2241_12217%22"))
insDoc(aux1, gLnk("S","Kolorniki","/go/_category/?idc=%2241_12160%22"))
insDoc(aux1, gLnk("S","Szczotki , Filce","/go/_category/?idc=%2241_12181%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2241_12171%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2241_12148%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2241_12148_138%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2241_12148_139%22"))
