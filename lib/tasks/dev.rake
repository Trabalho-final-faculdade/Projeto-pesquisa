namespace :dev do
  desc "Configura o ambiente de desenvolvimento"
  task setup: :environment do
    if Rails.env.development?
      show_spinner("Apagando BD....") { %x(rails db:drop) }
      show_spinner("Criando BD....") { %x(rails db:create) }
      show_spinner("Migrando BD....") { %x(rails db:migrate) }
      %x(rails dev:add_mining_types)
      %x(rails dev:add_coins)
    else
      puts "Você não está em ambiente de desenvolvimento!"
    end
  end

  desc "Cadastra as moedas"
  task add_coins: :environment do
    show_spinner("Cadastrando as moedas....") do
      coins = [
                {
                  description: "Bitcoin",
                  acronym: "BTC",
                  url_image: "https://banner2.kisspng.com/20180604/zya/kisspng-bitcoin-com-cryptocurrency-logo-zazzle-kibuba-btc-5b15aa1f157d09.468430171528146463088.jpg",
                  mining_type: MiningType.find_by(acronym: "PoW")
                },
                {
                  description: "Ethereum",
                  acronym: "ETC",
                  url_image: "https://cdn2.iconfinder.com/data/icons/cryptocurrency-5/100/cryptocurrency_blockchain_crypto-02-512.png",
                  mining_type: MiningType.all.sample
                },
                {
                  description: "Dash",
                  acronym: "DASH",
                  url_image: "https://cdn1.iconfinder.com/data/icons/cryptocurrency-round-color/128/blockchain_cryptocurrency_currency_Dash_Darkcoin_XCoin_1-512.png",
                  mining_type: MiningType.all.sample
                },
                {
                  description: "Iota",
                  acronym: "IOT",
                  url_image: "https://criptohub.com.br/assets/svg/svg008.svg",
                  mining_type: MiningType.all.sample
                },
                {
                  description: "ZCash",
                  acronym: "ZEC",
                  url_image: "https://z.cash/wp-content/uploads/2019/03/zcash-icon-fullcolor.png",
                  mining_type: MiningType.all.sample
                }
              ]
      coins.each do |coin|
        Coin.find_or_create_by!(coin)
      end
    end
  end

  desc "Cadastra os tipos de mineração"
  task add_mining_types: :environment do
    show_spinner("Cadastrando os tipos de mineração...") do
    mining_types = [
      {description: "Proof of Work", acronym: "PoW"},
      {description: "Proof of Stake", acronym: "PoS"},
      {description: "Proof of Capacity", acronym: "PoC"}
    ]
      mining_types.each do |mining_type|
        MiningType.find_or_create_by!(mining_type)
      end
    end
  end

private
  def show_spinner(msg_start, msg_end = "Concluído!!")
    spinner = TTY::Spinner.new("[:spinner] #{msg_start}")
    spinner.auto_spin
    yield
    spinner.success("(#{msg_end})")
  end
end
