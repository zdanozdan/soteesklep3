USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Agar","/go/_category/?idc=%2232_12095%22"))
aux2 = insFld(aux1, gFld("Materia³y i elementy protez","/go/_category/?idc=%2232_12058%22"))
aux3 = insFld(aux2, gFld("Akryle","/go/_category/?idc=%2232_12058_27%22"))
insDoc(aux3, gLnk("S","Futura Press","/go/_category/?idc=%2232_12058_27_58%22"))
insDoc(aux3, gLnk("S","FuturaSelf","/go/_category/?idc=%2232_12058_27_48%22"))
aux2 = insFld(aux1, gFld("Metale","/go/_category/?idc=%2232_12085%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2232_12085_45%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2232_12085_44%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2232_12081%22"))
