/*
    Exercice 3 : comprendre du code dans un langage que vous ne maitrisez pas forcément.
    Transmettez le code suivant à une IA grand public et tentez de lui faire analyser ce que fait le code :
*/

Game::Game()
{
    this->levels = std::list<Level *>();
    this->player = new Player(2, 2, UP);
    this->loadLevels();

    if ( SDL_Init( SDL_INIT_EVERYTHING ) < 0 ) {
        std::cout << "Error initializing SDL: " << SDL_GetError() << std::endl;
        system("pause");
        return;
    }

    this->window = SDL_CreateWindow( "Example", SDL_WINDOWPOS_UNDEFINED, SDL_WINDOWPOS_UNDEFINED, 320, 320, SDL_WINDOW_SHOWN );

    if ( !this->window ) {
        std::cout << "Error creating window: " << SDL_GetError()  << std::endl;
        return;
    }

    this->winSurface = SDL_GetWindowSurface( this->window );

    if ( !this->winSurface ) {
        std::cout << "Error getting surface: " << SDL_GetError() << std::endl;
        return;
    }

    SDL_FillRect( this->winSurface, NULL, SDL_MapRGB( this->winSurface->format, 255, 255, 255 ) );

    SDL_UpdateWindowSurface( this->window );
}
Soft-wrap