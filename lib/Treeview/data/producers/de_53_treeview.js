USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_39%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Kolorniki","/go/_category/?idc=%2232_12071%22"))
insDoc(aux1, gLnk("S","Licowanie","/go/_category/?idc=%2232_12062%22"))
aux2 = insFld(aux1, gFld("Materia³y i elementy protez","/go/_category/?idc=%2232_12058%22"))
insDoc(aux2, gLnk("S","Akryle","/go/_category/?idc=%2232_12058_27%22"))
aux3 = insFld(aux2, gFld("Zêby","/go/_category/?idc=%2232_12058_12%22"))
insDoc(aux3, gLnk("S","Boczne","/go/_category/?idc=%2232_12058_12_9%22"))
insDoc(aux3, gLnk("S","Przednie","/go/_category/?idc=%2232_12058_12_11%22"))
insDoc(aux1, gLnk("S","Szczotki","/go/_category/?idc=%2232_12078%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2232_12081%22"))
