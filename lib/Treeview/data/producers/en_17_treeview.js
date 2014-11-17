USETEXTLINKS=1
STARTALLOPEN=1
USEFRAMES=0
USEICONS=1
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Budowa modeli","/go/_category/?idc=%2232_12065%22"))
aux2 = insFld(aux1, gFld("Licowanie","/go/_category/?idc=%2232_12062%22"))
insDoc(aux2, gLnk("S","Kompozyty","/go/_category/?idc=%2232_12062_14%22"))
insDoc(aux2, gLnk("S","Porcelana","/go/_category/?idc=%2232_12062_18%22"))
aux2 = insFld(aux1, gFld("Materia³y i elementy protez","/go/_category/?idc=%2232_12058%22"))
aux3 = insFld(aux2, gFld("Zêby","/go/_category/?idc=%2232_12058_12%22"))
insDoc(aux3, gLnk("S","Boczne","/go/_category/?idc=%2232_12058_12_9%22"))
insDoc(aux3, gLnk("S","Przednie","/go/_category/?idc=%2232_12058_12_11%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_34%22"))
