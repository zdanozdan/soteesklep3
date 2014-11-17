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
insDoc(aux1, gLnk("S","Lakier pokrywaj±cy","/go/_category/?idc=%2232_12133%22"))
aux2 = insFld(aux1, gFld("Licowanie","/go/_category/?idc=%2232_12062%22"))
aux3 = insFld(aux2, gFld("Akryle","/go/_category/?idc=%2232_12062_27%22"))
insDoc(aux3, gLnk("S","Duracryl","/go/_category/?idc=%2232_12062_27_33%22"))
insDoc(aux3, gLnk("S","Superpont","/go/_category/?idc=%2232_12062_27_41%22"))
aux2 = insFld(aux1, gFld("Materia³y i elementy protez","/go/_category/?idc=%2232_12058%22"))
aux3 = insFld(aux2, gFld("Akryle","/go/_category/?idc=%2232_12058_27%22"))
insDoc(aux3, gLnk("S","Duracrol","/go/_category/?idc=%2232_12058_27_32%22"))
insDoc(aux3, gLnk("S","Duracryl","/go/_category/?idc=%2232_12058_27_33%22"))
insDoc(aux3, gLnk("S","Superacryl","/go/_category/?idc=%2232_12058_27_34%22"))
