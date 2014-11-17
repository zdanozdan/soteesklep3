USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Grubo¶ciomierze","/go/_category/?idc=%2258_12426%22"))
insDoc(aux1, gLnk("S","Kleszcze protetyczne i ortodontyczne","/go/_category/?idc=%2258_12445%22"))
insDoc(aux1, gLnk("S","Narzêdzia do modelowania","/go/_category/?idc=%2258_12401%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Zubehör","/go/_category/?idc=%2259_12389%22"))
insDoc(aux1, gLnk("S","Endodoncja","/go/_category/?idc=%2259_12373%22"))
insDoc(aux1, gLnk("S","£y¿ki wyciskowe","/go/_category/?idc=%2259_12440%22"))
aux2 = insFld(aux1, gFld("Materia³y jednorazowe","/go/_category/?idc=%2259_12478%22"))
insDoc(aux2, gLnk("S","Maseczki","/go/_category/?idc=%2259_12478_492%22"))
insDoc(aux2, gLnk("S","Skalpele","/go/_category/?idc=%2259_12478_494%22"))
insDoc(aux1, gLnk("S","Narzêdzia i instrumenty stomatologiczne","/go/_category/?idc=%2259_12387%22"))
insDoc(aux1, gLnk("S","Odbudowa zêbów","/go/_category/?idc=%2259_12393%22"))
