USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
aux2 = insFld(aux1, gFld("Materia³y i elementy protez","/go/_category/?idc=%2232_12058%22"))
insDoc(aux2, gLnk("S","P³ytki szelakowe","/go/_category/?idc=%2232_12058_55%22"))
aux3 = insFld(aux2, gFld("Zêby","/go/_category/?idc=%2232_12058_12%22"))
insDoc(aux3, gLnk("S","Boczne","/go/_category/?idc=%2232_12058_12_9%22"))
insDoc(aux3, gLnk("S","Przednie","/go/_category/?idc=%2232_12058_12_11%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_34%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2234_12084%22"))
insDoc(aux1, gLnk("S","Materia³y wyciskowe","/go/_category/?idc=%2234_12073%22"))
