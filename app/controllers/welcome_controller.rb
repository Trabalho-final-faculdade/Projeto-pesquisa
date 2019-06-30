class WelcomeController < ApplicationController
  def index
  cookies[:curso] = "curso ruby"
  session[:login] = "danilo"
    @nome = params[:nome]
    @curso = params[:curso]
  end
end
