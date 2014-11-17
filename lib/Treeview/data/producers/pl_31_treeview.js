USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Adapta","/go/_category/?idc=%2232_12083%22"))
insDoc(aux1, gLnk("S","Agar","/go/_category/?idc=%2232_12095%22"))
insDoc(aux1, gLnk("S","Budowa modeli","/go/_category/?idc=%2232_12065%22"))
aux2 = insFld(aux1, gFld("Masy os³aniaj±ce","/go/_category/?idc=%2232_12086%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2232_12086_45%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2232_12086_44%22"))
aux2 = insFld(aux1, gFld("Metale","/go/_category/?idc=%2232_12085%22"))
insDoc(aux2, gLnk("S","Korony i mosty","/go/_category/?idc=%2232_12085_45%22"))
insDoc(aux2, gLnk("S","Protezy szkieletowe","/go/_category/?idc=%2232_12085_44%22"))
insDoc(aux1, gLnk("S","Narzêdzia i materia³y do obróbki","/go/_category/?idc=%2232_12080%22"))
insDoc(aux1, gLnk("S","Szczotki","/go/_category/?idc=%2232_12078%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2232_12081%22"))
insDoc(aux2, gLnk("S","Wosk na protezy szkieletowe","/go/_category/?idc=%2232_12081_131%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2232_12081_43%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2232_12081_46%22"))
