USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
insDoc(aux1, gLnk("S","Gipsy","/go/_category/?idc=%2258_12427%22"))
insDoc(aux1, gLnk("S","Separatory diamentowe","/go/_category/?idc=%2258_12413%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","£y¿ki wyciskowe","/go/_category/?idc=%2259_12440%22"))
aux2 = insFld(aux1, gFld("Masy wyciskowe","/go/_category/?idc=%2259_12383%22"))
insDoc(aux2, gLnk("S","Akcesoria do mas","/go/_category/?idc=%2259_12383_393%22"))
insDoc(aux2, gLnk("S","Silikonowe","/go/_category/?idc=%2259_12383_387%22"))
insDoc(aux1, gLnk("S","Materia³y jednorazowe","/go/_category/?idc=%2259_12478%22"))
