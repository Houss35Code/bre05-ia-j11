#include <stdio.h>

int main(int argc, char **argv, char **envp)
{
	if(argc < 5)  // ✅ Plus de point-virgule !
	{
		printf("Not enough arguments.\n");
	}

	return 0;
}