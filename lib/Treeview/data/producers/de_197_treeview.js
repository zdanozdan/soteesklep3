USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie wählen","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_62%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_58%22"))
aux2 = insFld(aux1, gFld("Akryle","/go/_category/?idc=%2258_12377%22"))
insDoc(aux2, gLnk("S","Duracrol","/go/_category/?idc=%2258_12377_400%22"))
insDoc(aux2, gLnk("S","Duracryl","/go/_category/?idc=%2258_12377_401%22"))
insDoc(aux2, gLnk("S","Superacryl","/go/_category/?idc=%2258_12377_402%22"))
aux2 = insFld(aux1, gFld("Akryle do licowania","/go/_category/?idc=%2258_12438%22"))
insDoc(aux2, gLnk("S","Duracryl","/go/_category/?idc=%2258_12438_401%22"))
insDoc(aux2, gLnk("S","Superpont","/go/_category/?idc=%2258_12438_410%22"))
insDoc(aux1, gLnk("S","Farby opakerowe","/go/_category/?idc=%2258_12485%22"))
insDoc(aux1, gLnk("S","Kolorniki","/go/_category/?idc=%2258_12381%22"))
insDoc(aux1, gLnk("S","P³ytki szelakowe","/go/_category/?idc=%2258_12415%22"))
aux2 = insFld(aux1, gFld("Zêby","/go/_category/?idc=%2258_12368%22"))
insDoc(aux2, gLnk("S","Boczne","/go/_category/?idc=%2258_12368_369%22"))
insDoc(aux2, gLnk("S","Przednie","/go/_category/?idc=%2258_12368_370%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2259_12385%22"))
aux2 = insFld(aux1, gFld("Masy wyciskowe","/go/_category/?idc=%2259_12383%22"))
insDoc(aux2, gLnk("S","Alginatowe","/go/_category/?idc=%2259_12383_380%22"))
insDoc(aux2, gLnk("S","Inne","/go/_category/?idc=%2259_12383_413%22"))
insDoc(aux2, gLnk("S","Silikonowe","/go/_category/?idc=%2259_12383_387%22"))
insDoc(aux1, gLnk("S","Materia³y jednorazowe","/go/_category/?idc=%2259_12478%22"))
aux2 = insFld(aux1, gFld("Wype³nienia","/go/_category/?idc=%2259_12371%22"))
insDoc(aux2, gLnk("S","Glassjonomery","/go/_category/?idc=%2259_12371_481%22"))
insDoc(aux2, gLnk("S","Kompozyty chemoutwardzalne","/go/_category/?idc=%2259_12371_386%22"))
