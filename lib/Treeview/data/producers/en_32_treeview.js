USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_39%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Budowa modeli","/go/_category/?idc=%2232_12065%22"))
aux2 = insFld(aux1, gFld("Materia³y i elementy protez","/go/_category/?idc=%2232_12058%22"))
insDoc(aux2, gLnk("S","Akryle","/go/_category/?idc=%2232_12058_27%22"))
insDoc(aux2, gLnk("S","Materia³y do pod¶cieleñ","/go/_category/?idc=%2232_12058_64%22"))
insDoc(aux1, gLnk("S","Puszki , ramki","/go/_category/?idc=%2232_12120%22"))
insDoc(aux1, gLnk("S","Woski","/go/_category/?idc=%2232_12081%22"))
