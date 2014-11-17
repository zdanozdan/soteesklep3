USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_62%22"))
aux2 = insFld(aux1, gFld("Aparaty sta³e","/go/_category/?idc=%2262_12459%22"))
insDoc(aux2, gLnk("S","Elastomery","/go/_category/?idc=%2262_12459_437%22"))
insDoc(aux2, gLnk("S","Klej do zamków","/go/_category/?idc=%2262_12459_456%22"))
insDoc(aux2, gLnk("S","Ligatury,Druty,£uki","/go/_category/?idc=%2262_12459_442%22"))
insDoc(aux2, gLnk("S","Zamki Ceramiczne","/go/_category/?idc=%2262_12459_458%22"))
insDoc(aux2, gLnk("S","Zamki Metalowe","/go/_category/?idc=%2262_12459_461%22"))
insDoc(aux1, gLnk("S","£y¿ki wyciskowe","/go/_category/?idc=%2262_12440%22"))
