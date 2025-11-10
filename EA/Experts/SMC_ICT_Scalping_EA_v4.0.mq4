//+------------------------------------------------------------------+
//|                                    SMC ICT Scalping EA v4.0.mq4 |
//|                                      Copyright 2025, zerxenzon   |
//|                                                                  |
//+------------------------------------------------------------------+
#property copyright "Copyright 2025, zerxenzon"
#property link      ""
#property version   "4.00"
#property strict

//+------------------------------------------------------------------+
//| Input Parameters                                                  |
//+------------------------------------------------------------------+

//===== PHASE 1: STRICT RISK CONTROL =====
input group "=== PHASE 1: RISK MANAGEMENT ==="
input double   StopLossPips = 10.0;           // Fixed Stop Loss (Pips) - Maximum 10
input double   MaxLossPerTrade = 100000;      // Max Loss Per Trade (IDR)
input double   DailyLossLimit = 200000;       // Daily Loss Limit (IDR)
input double   MinLotSize = 0.01;             // Minimum Lot Size
input double   MaxLotSize = 0.10;             // Maximum Lot Size

//===== PHASE 2: PROFIT OPTIMIZATION =====
input group "=== PHASE 2: PROFIT OPTIMIZATION ==="
input double   TP1_Pips = 5.0;                // TP1 Distance (Pips)
input double   TP1_Percent = 20.0;            // TP1 Close Percentage
input double   TP2_Pips = 10.0;               // TP2 Distance (Pips)
input double   TP2_Percent = 30.0;            // TP2 Close Percentage
input double   TP3_Pips = 15.0;               // TP3 Distance (Pips)
input double   TP3_Percent = 30.0;            // TP3 Close Percentage
input double   TP4_Pips = 20.0;               // TP4 Distance (Pips)
input double   TP4_Percent = 20.0;            // TP4 Close Percentage

input bool     EnableKillZone = true;         // Enable Kill Zone Restriction
input int      LondonStartHour = 8;           // London Session Start (UTC)
input int      LondonEndHour = 11;            // London Session End (UTC)
input int      NYStartHour = 13;              // NY Session Start (UTC)
input int      NYEndHour = 16;                // NY Session End (UTC)

input double   LondonLotSize = 0.05;          // London Session Lot Size
input double   NYLotSize = 0.05;              // NY Session Lot Size
input double   OffPeakLotSize = 0.01;         // Off-Peak Lot Size

input int      MinConfluencePoints = 5;       // Minimum Confluence Points for Entry

//===== PHASE 3: AUTO-ADJUSTMENT & MONITORING =====
input group "=== PHASE 3: AUTO-ADJUSTMENT ==="
input int      WinRateTrackingPeriod = 20;    // Win Rate Tracking Period (trades)
input double   HighWinRateThreshold = 75.0;   // High Win Rate Threshold (%)
input double   MediumWinRateThreshold = 60.0; // Medium Win Rate Threshold (%)
input double   HighWinRateLot = 0.06;         // Lot Size for High Win Rate
input double   MediumWinRateLot = 0.05;       // Lot Size for Medium Win Rate
input double   LowWinRateLot = 0.03;          // Lot Size for Low Win Rate

input int      LosingStreakThreshold = 3;     // Losing Streak Threshold
input double   DailyTarget1 = 300000;         // Daily Target Alert 1 (IDR)
input double   DailyTarget2 = 400000;         // Daily Target Alert 2 (IDR)
input double   DailyTarget3 = 500000;         // Daily Target Alert 3 (IDR)

//===== TECHNICAL SPECIFICATIONS =====
input group "=== TECHNICAL SPECIFICATIONS ==="
input string   TradingSymbol = "XAUUSD";      // Trading Symbol
input ENUM_TIMEFRAMES Timeframe = PERIOD_M1;  // Trading Timeframe
input int      MagicNumber = 888888;          // Magic Number
input int      Slippage = 3;                  // Slippage (Points)

//===== SMC/ICT SETTINGS =====
input group "=== SMC/ICT PARAMETERS ==="
input bool     EnableOrderBlocks = true;      // Enable Order Blocks
input bool     EnableFVG = true;              // Enable Fair Value Gap
input bool     EnableBOS = true;              // Enable Break of Structure
input bool     EnableCHoCH = true;            // Enable Change of Character
input bool     EnableLiquiditySweep = true;   // Enable Liquidity Sweeps
input int      OrderBlockLookback = 50;       // Order Block Lookback Periods
input int      FVGLookback = 30;              // FVG Lookback Periods
input int      SwingLookback = 20;            // Swing Point Lookback
input double   LiquiditySwipeDistance = 5.0;  // Liquidity Swipe Distance (Pips)

//+------------------------------------------------------------------+
//| Global Variables                                                  |
//+------------------------------------------------------------------+
double dailyProfit = 0.0;
double dailyLoss = 0.0;
datetime lastTradeDate = 0;
int totalTrades = 0;
int winningTrades = 0;
int losingTrades = 0;
int consecutiveLosses = 0;
double currentWinRate = 0.0;
bool dailyTarget1Reached = false;
bool dailyTarget2Reached = false;
bool dailyTarget3Reached = false;

// Trade history arrays
double tradeResults[];
datetime tradeTimestamps[];

// SMC/ICT tracking
double orderBlockHigh[], orderBlockLow[];
datetime orderBlockTime[];
double fvgTop[], fvgBottom[];
datetime fvgTime[];
double swingHigh[], swingLow[];
datetime swingTime[];

// Position tracking
struct TradeInfo {
   int ticket;
   double entryPrice;
   double lotSize;
   bool tp1Closed;
   bool tp2Closed;
   bool tp3Closed;
   bool tp4Closed;
   double remainingLots;
   int type;
};

TradeInfo activeTrades[];

//+------------------------------------------------------------------+
//| Expert initialization function                                    |
//+------------------------------------------------------------------+
int OnInit() {
   Print("=== SMC ICT Scalping EA v4.0 Initialized ===");
   Print("Account Balance: ", AccountBalance(), " ", AccountCurrency());
   Print("Stop Loss: ", StopLossPips, " pips");
   Print("Max Loss Per Trade: ", MaxLossPerTrade, " IDR");
   Print("Daily Loss Limit: ", DailyLossLimit, " IDR");
   Print("Kill Zone Trading: ", EnableKillZone ? "Enabled" : "Disabled");
   Print("Minimum Confluence Points: ", MinConfluencePoints);
   Print("Magic Number: ", MagicNumber);
   
   // Initialize arrays
   ArrayResize(tradeResults, WinRateTrackingPeriod);
   ArrayResize(tradeTimestamps, WinRateTrackingPeriod);
   ArrayInitialize(tradeResults, 0);
   ArrayInitialize(tradeTimestamps, 0);
   
   // Reset daily statistics
   ResetDailyStatistics();
   
   // Display initial info
   Comment(GetStatusComment());
   
   return(INIT_SUCCEEDED);
}

//+------------------------------------------------------------------+
//| Expert deinitialization function                                  |
//+------------------------------------------------------------------+
void OnDeinit(const int reason) {
   Print("=== SMC ICT Scalping EA v4.0 Deinitialized ===");
   Print("Reason: ", reason);
   Comment("");
}

//+------------------------------------------------------------------+
//| Expert tick function                                              |
//+------------------------------------------------------------------+
void OnTick() {
   // Check if new day started
   if(TimeDayOfYear(TimeCurrent()) != TimeDayOfYear(lastTradeDate)) {
      ResetDailyStatistics();
   }
   
   // Update daily P/L
   UpdateDailyProfitLoss();
   
   // Check daily loss limit
   if(dailyLoss >= DailyLossLimit) {
      Comment("DAILY LOSS LIMIT REACHED! Trading stopped for today.\n" + GetStatusComment());
      return;
   }
   
   // Check daily targets
   CheckDailyTargets();
   
   // Update partial closures for active trades
   ManageActiveTrades();
   
   // Check if we can trade (kill zone)
   if(EnableKillZone && !IsInKillZone()) {
      Comment("Outside Kill Zone - Waiting for London/NY session\n" + GetStatusComment());
      return;
   }
   
   // Check if we already have open positions
   int openPositions = CountOpenPositions();
   if(openPositions > 0) {
      Comment("Active trades: " + IntegerToString(openPositions) + "\n" + GetStatusComment());
      return;
   }
   
   // Calculate win rate and adjust lot size
   currentWinRate = CalculateWinRate();
   
   // Analyze market for entry signals
   int signal = AnalyzeMarketEntry();
   
   if(signal == OP_BUY) {
      double lotSize = CalculateLotSize(OP_BUY);
      if(lotSize > 0) {
         OpenBuyTrade(lotSize);
      }
   }
   else if(signal == OP_SELL) {
      double lotSize = CalculateLotSize(OP_SELL);
      if(lotSize > 0) {
         OpenSellTrade(lotSize);
      }
   }
   
   // Update display
   Comment(GetStatusComment());
}

//+------------------------------------------------------------------+
//| PHASE 1: RISK MANAGEMENT FUNCTIONS                               |
//+------------------------------------------------------------------+

//+------------------------------------------------------------------+
//| Calculate lot size based on risk parameters                       |
//+------------------------------------------------------------------+
double CalculateLotSize(int orderType) {
   double lotSize = 0.0;
   
   // Base lot size from session
   if(IsInKillZone()) {
      int hour = TimeHour(TimeCurrent());
      if(hour >= LondonStartHour && hour < LondonEndHour) {
         lotSize = LondonLotSize;
      }
      else if(hour >= NYStartHour && hour < NYEndHour) {
         lotSize = NYLotSize;
      }
      else {
         lotSize = OffPeakLotSize;
      }
   }
   else {
      lotSize = OffPeakLotSize;
   }
   
   // Adjust based on win rate (PHASE 3)
   if(currentWinRate >= HighWinRateThreshold) {
      lotSize = HighWinRateLot;
   }
   else if(currentWinRate >= MediumWinRateThreshold) {
      lotSize = MediumWinRateLot;
   }
   else if(currentWinRate < MediumWinRateThreshold && totalTrades >= 5) {
      lotSize = LowWinRateLot;
   }
   
   // Reduce lot on losing streak
   if(consecutiveLosses >= LosingStreakThreshold) {
      lotSize = lotSize * 0.5;
      if(lotSize < MinLotSize) lotSize = MinLotSize;
   }
   
   // Risk-based lot size calculation
   double accountBalance = AccountBalance();
   double riskAmount = MaxLossPerTrade;
   
   // Convert to account currency equivalent
   double pointValue = MarketInfo(TradingSymbol, MODE_TICKVALUE);
   double stopLossPoints = StopLossPips * 10; // Convert pips to points for XAUUSD
   
   if(pointValue > 0 && stopLossPoints > 0) {
      double maxLotByRisk = riskAmount / (stopLossPoints * pointValue);
      if(maxLotByRisk < lotSize) {
         lotSize = maxLotByRisk;
      }
   }
   
   // Enforce min/max limits
   if(lotSize < MinLotSize) lotSize = MinLotSize;
   if(lotSize > MaxLotSize) lotSize = MaxLotSize;
   
   // Normalize lot size
   double minLot = MarketInfo(TradingSymbol, MODE_MINLOT);
   double maxLot = MarketInfo(TradingSymbol, MODE_MAXLOT);
   double lotStep = MarketInfo(TradingSymbol, MODE_LOTSTEP);
   
   lotSize = MathFloor(lotSize / lotStep) * lotStep;
   lotSize = MathMax(minLot, MathMin(maxLot, lotSize));
   
   return lotSize;
}

//+------------------------------------------------------------------+
//| Check if daily loss limit would be exceeded                       |
//+------------------------------------------------------------------+
bool WouldExceedDailyLimit(double potentialLoss) {
   return (dailyLoss + potentialLoss) >= DailyLossLimit;
}

//+------------------------------------------------------------------+
//| PHASE 2: PROFIT OPTIMIZATION FUNCTIONS                           |
//+------------------------------------------------------------------+

//+------------------------------------------------------------------+
//| Check if current time is in kill zone                             |
//+------------------------------------------------------------------+
bool IsInKillZone() {
   if(!EnableKillZone) return true;
   
   datetime currentTime = TimeCurrent();
   int hour = TimeHour(currentTime);
   
   // London session (08:00-11:00 UTC)
   if(hour >= LondonStartHour && hour < LondonEndHour) {
      return true;
   }
   
   // NY session (13:00-16:00 UTC)
   if(hour >= NYStartHour && hour < NYEndHour) {
      return true;
   }
   
   return false;
}

//+------------------------------------------------------------------+
//| Manage active trades with partial closures                        |
//+------------------------------------------------------------------+
void ManageActiveTrades() {
   for(int i = ArraySize(activeTrades) - 1; i >= 0; i--) {
      if(!OrderSelect(activeTrades[i].ticket, SELECT_BY_TICKET)) {
         // Trade closed, remove from array
         RemoveActiveTradeByIndex(i);
         continue;
      }
      
      if(OrderCloseTime() > 0) {
         // Trade already closed
         RemoveActiveTradeByIndex(i);
         continue;
      }
      
      double currentPrice = (activeTrades[i].type == OP_BUY) ? Bid : Ask;
      double entryPrice = activeTrades[i].entryPrice;
      double pips = 0;
      
      if(activeTrades[i].type == OP_BUY) {
         pips = (currentPrice - entryPrice) / Point / 10;
      }
      else {
         pips = (entryPrice - currentPrice) / Point / 10;
      }
      
      // Check TP levels and execute partial closures
      if(!activeTrades[i].tp1Closed && pips >= TP1_Pips) {
         ClosePartialPosition(i, TP1_Percent, "TP1");
         activeTrades[i].tp1Closed = true;
      }
      else if(!activeTrades[i].tp2Closed && pips >= TP2_Pips) {
         ClosePartialPosition(i, TP2_Percent, "TP2");
         activeTrades[i].tp2Closed = true;
      }
      else if(!activeTrades[i].tp3Closed && pips >= TP3_Pips) {
         ClosePartialPosition(i, TP3_Percent, "TP3");
         activeTrades[i].tp3Closed = true;
      }
      else if(!activeTrades[i].tp4Closed && pips >= TP4_Pips) {
         ClosePartialPosition(i, TP4_Percent, "TP4");
         activeTrades[i].tp4Closed = true;
      }
   }
}

//+------------------------------------------------------------------+
//| Close partial position                                            |
//+------------------------------------------------------------------+
void ClosePartialPosition(int tradeIndex, double percentage, string tpLevel) {
   if(!OrderSelect(activeTrades[tradeIndex].ticket, SELECT_BY_TICKET)) return;
   
   double lotsToClose = activeTrades[tradeIndex].remainingLots * (percentage / 100.0);
   double minLot = MarketInfo(TradingSymbol, MODE_MINLOT);
   double lotStep = MarketInfo(TradingSymbol, MODE_LOTSTEP);
   
   lotsToClose = MathFloor(lotsToClose / lotStep) * lotStep;
   
   if(lotsToClose < minLot) return;
   if(lotsToClose > activeTrades[tradeIndex].remainingLots) {
      lotsToClose = activeTrades[tradeIndex].remainingLots;
   }
   
   double closePrice = (activeTrades[tradeIndex].type == OP_BUY) ? Bid : Ask;
   
   bool closed = OrderClose(activeTrades[tradeIndex].ticket, lotsToClose, closePrice, Slippage, clrGreen);
   
   if(closed) {
      activeTrades[tradeIndex].remainingLots -= lotsToClose;
      Print(tpLevel, " reached! Closed ", lotsToClose, " lots at ", closePrice);
      
      // If all lots closed, remove from active trades
      if(activeTrades[tradeIndex].remainingLots <= minLot) {
         RemoveActiveTradeByIndex(tradeIndex);
      }
   }
}

//+------------------------------------------------------------------+
//| PHASE 3: AUTO-ADJUSTMENT & MONITORING FUNCTIONS                  |
//+------------------------------------------------------------------+

//+------------------------------------------------------------------+
//| Calculate win rate from recent trades                             |
//+------------------------------------------------------------------+
double CalculateWinRate() {
   if(totalTrades == 0) return 0.0;
   
   int validTrades = MathMin(totalTrades, WinRateTrackingPeriod);
   if(validTrades == 0) return 0.0;
   
   int wins = 0;
   for(int i = 0; i < validTrades; i++) {
      if(tradeResults[i] > 0) wins++;
   }
   
   return (double)wins / (double)validTrades * 100.0;
}

//+------------------------------------------------------------------+
//| Update daily profit/loss                                          |
//+------------------------------------------------------------------+
void UpdateDailyProfitLoss() {
   dailyProfit = 0.0;
   dailyLoss = 0.0;
   
   datetime today = TimeCurrent();
   
   for(int i = OrdersHistoryTotal() - 1; i >= 0; i--) {
      if(!OrderSelect(i, SELECT_BY_POS, MODE_HISTORY)) continue;
      if(OrderMagicNumber() != MagicNumber) continue;
      if(OrderSymbol() != TradingSymbol) continue;
      
      if(TimeDayOfYear(OrderCloseTime()) == TimeDayOfYear(today)) {
         double profit = OrderProfit() + OrderSwap() + OrderCommission();
         if(profit > 0) {
            dailyProfit += profit;
         }
         else {
            dailyLoss += MathAbs(profit);
         }
      }
   }
}

//+------------------------------------------------------------------+
//| Check daily targets and send alerts                               |
//+------------------------------------------------------------------+
void CheckDailyTargets() {
   double totalDaily = dailyProfit - dailyLoss;
   
   if(!dailyTarget1Reached && totalDaily >= DailyTarget1) {
      dailyTarget1Reached = true;
      Alert("Daily Target 1 Reached: ", DailyTarget1, " IDR");
      Print("Daily Target 1 Reached: ", DailyTarget1, " IDR");
   }
   
   if(!dailyTarget2Reached && totalDaily >= DailyTarget2) {
      dailyTarget2Reached = true;
      Alert("Daily Target 2 Reached: ", DailyTarget2, " IDR");
      Print("Daily Target 2 Reached: ", DailyTarget2, " IDR");
   }
   
   if(!dailyTarget3Reached && totalDaily >= DailyTarget3) {
      dailyTarget3Reached = true;
      Alert("Daily Target 3 Reached: ", DailyTarget3, " IDR! EXCELLENT!");
      Print("Daily Target 3 Reached: ", DailyTarget3, " IDR");
   }
}

//+------------------------------------------------------------------+
//| Reset daily statistics                                            |
//+------------------------------------------------------------------+
void ResetDailyStatistics() {
   dailyProfit = 0.0;
   dailyLoss = 0.0;
   dailyTarget1Reached = false;
   dailyTarget2Reached = false;
   dailyTarget3Reached = false;
   lastTradeDate = TimeCurrent();
   Print("Daily statistics reset for new trading day");
}

//+------------------------------------------------------------------+
//| Add trade result to tracking                                      |
//+------------------------------------------------------------------+
void AddTradeResult(double profit) {
   // Shift array
   for(int i = WinRateTrackingPeriod - 1; i > 0; i--) {
      tradeResults[i] = tradeResults[i-1];
      tradeTimestamps[i] = tradeTimestamps[i-1];
   }
   
   // Add new result
   tradeResults[0] = profit;
   tradeTimestamps[0] = TimeCurrent();
   
   totalTrades++;
   
   if(profit > 0) {
      winningTrades++;
      consecutiveLosses = 0;
   }
   else {
      losingTrades++;
      consecutiveLosses++;
   }
   
   // Alert on losing streak
   if(consecutiveLosses >= LosingStreakThreshold) {
      Alert("LOSING STREAK DETECTED: ", consecutiveLosses, " consecutive losses!");
      Print("Losing streak: ", consecutiveLosses, " - Auto-reducing lot size");
   }
}

//+------------------------------------------------------------------+
//| SMC/ICT ANALYSIS FUNCTIONS                                        |
//+------------------------------------------------------------------+

//+------------------------------------------------------------------+
//| Analyze market for entry signals                                  |
//+------------------------------------------------------------------+
int AnalyzeMarketEntry() {
   int confluencePoints = 0;
   bool bullishSignal = false;
   bool bearishSignal = false;
   
   // Detect Order Blocks
   if(EnableOrderBlocks) {
      int obSignal = DetectOrderBlocks();
      if(obSignal == OP_BUY) {
         bullishSignal = true;
         confluencePoints++;
      }
      else if(obSignal == OP_SELL) {
         bearishSignal = true;
         confluencePoints++;
      }
   }
   
   // Detect Fair Value Gaps
   if(EnableFVG) {
      int fvgSignal = DetectFairValueGaps();
      if(fvgSignal == OP_BUY) {
         bullishSignal = true;
         confluencePoints++;
      }
      else if(fvgSignal == OP_SELL) {
         bearishSignal = true;
         confluencePoints++;
      }
   }
   
   // Detect Break of Structure
   if(EnableBOS) {
      int bosSignal = DetectBreakOfStructure();
      if(bosSignal == OP_BUY) {
         bullishSignal = true;
         confluencePoints++;
      }
      else if(bosSignal == OP_SELL) {
         bearishSignal = true;
         confluencePoints++;
      }
   }
   
   // Detect Change of Character
   if(EnableCHoCH) {
      int chochSignal = DetectChangeOfCharacter();
      if(chochSignal == OP_BUY) {
         bullishSignal = true;
         confluencePoints++;
      }
      else if(chochSignal == OP_SELL) {
         bearishSignal = true;
         confluencePoints++;
      }
   }
   
   // Detect Liquidity Sweeps
   if(EnableLiquiditySweep) {
      int lsSignal = DetectLiquiditySweeps();
      if(lsSignal == OP_BUY) {
         bullishSignal = true;
         confluencePoints++;
      }
      else if(lsSignal == OP_SELL) {
         bearishSignal = true;
         confluencePoints++;
      }
   }
   
   // Check if minimum confluence met
   if(confluencePoints < MinConfluencePoints) {
      return -1;
   }
   
   // Return signal
   if(bullishSignal && !bearishSignal) {
      Print("BUY Signal detected with ", confluencePoints, " confluence points");
      return OP_BUY;
   }
   else if(bearishSignal && !bullishSignal) {
      Print("SELL Signal detected with ", confluencePoints, " confluence points");
      return OP_SELL;
   }
   
   return -1;
}

//+------------------------------------------------------------------+
//| Detect Order Blocks                                               |
//+------------------------------------------------------------------+
int DetectOrderBlocks() {
   double high[], low[], close[], open[];
   ArraySetAsSeries(high, true);
   ArraySetAsSeries(low, true);
   ArraySetAsSeries(close, true);
   ArraySetAsSeries(open, true);
   
   int copied = CopyHigh(TradingSymbol, Timeframe, 0, OrderBlockLookback, high);
   CopyLow(TradingSymbol, Timeframe, 0, OrderBlockLookback, low);
   CopyClose(TradingSymbol, Timeframe, 0, OrderBlockLookback, close);
   CopyOpen(TradingSymbol, Timeframe, 0, OrderBlockLookback, open);
   
   if(copied < OrderBlockLookback) return -1;
   
   // Bullish Order Block: Strong down candle followed by up move
   for(int i = 1; i < OrderBlockLookback - 2; i++) {
      double candleBody = MathAbs(close[i] - open[i]);
      bool strongBearCandle = (close[i] < open[i]) && (candleBody > (high[i] - low[i]) * 0.7);
      
      if(strongBearCandle) {
         bool priceReturnedToOB = (low[0] <= high[i] && low[0] >= low[i]);
         if(priceReturnedToOB && close[0] > open[0]) {
            return OP_BUY;
         }
      }
      
      // Bearish Order Block: Strong up candle followed by down move
      double candleBody2 = MathAbs(close[i] - open[i]);
      bool strongBullCandle = (close[i] > open[i]) && (candleBody2 > (high[i] - low[i]) * 0.7);
      
      if(strongBullCandle) {
         bool priceReturnedToOB = (high[0] >= low[i] && high[0] <= high[i]);
         if(priceReturnedToOB && close[0] < open[0]) {
            return OP_SELL;
         }
      }
   }
   
   return -1;
}

//+------------------------------------------------------------------+
//| Detect Fair Value Gaps (FVG)                                      |
//+------------------------------------------------------------------+
int DetectFairValueGaps() {
   double high[], low[];
   ArraySetAsSeries(high, true);
   ArraySetAsSeries(low, true);
   
   int copied = CopyHigh(TradingSymbol, Timeframe, 0, FVGLookback, high);
   CopyLow(TradingSymbol, Timeframe, 0, FVGLookback, low);
   
   if(copied < FVGLookback) return -1;
   
   // Bullish FVG: Gap between candle 2's high and candle 0's low
   for(int i = 2; i < FVGLookback - 1; i++) {
      double gap = low[i-2] - high[i];
      if(gap > 0) {
         // Check if price is filling the gap
         if(low[0] <= low[i-2] && low[0] >= high[i]) {
            return OP_BUY;
         }
      }
      
      // Bearish FVG: Gap between candle 2's low and candle 0's high
      double gap2 = low[i] - high[i-2];
      if(gap2 > 0) {
         if(high[0] >= low[i] && high[0] <= high[i-2]) {
            return OP_SELL;
         }
      }
   }
   
   return -1;
}

//+------------------------------------------------------------------+
//| Detect Break of Structure (BOS)                                   |
//+------------------------------------------------------------------+
int DetectBreakOfStructure() {
   double high[], low[];
   ArraySetAsSeries(high, true);
   ArraySetAsSeries(low, true);
   
   int copied = CopyHigh(TradingSymbol, Timeframe, 0, SwingLookback, high);
   CopyLow(TradingSymbol, Timeframe, 0, SwingLookback, low);
   
   if(copied < SwingLookback) return -1;
   
   // Find recent swing high/low
   double swingHigh = high[ArrayMaximum(high, 5, SwingLookback-5)];
   double swingLow = low[ArrayMinimum(low, 5, SwingLookback-5)];
   
   // Bullish BOS: Price breaks above recent swing high
   if(high[0] > swingHigh && high[1] <= swingHigh) {
      return OP_BUY;
   }
   
   // Bearish BOS: Price breaks below recent swing low
   if(low[0] < swingLow && low[1] >= swingLow) {
      return OP_SELL;
   }
   
   return -1;
}

//+------------------------------------------------------------------+
//| Detect Change of Character (CHoCH)                                |
//+------------------------------------------------------------------+
int DetectChangeOfCharacter() {
   double high[], low[], close[];
   ArraySetAsSeries(high, true);
   ArraySetAsSeries(low, true);
   ArraySetAsSeries(close, true);
   
   int copied = CopyHigh(TradingSymbol, Timeframe, 0, SwingLookback, high);
   CopyLow(TradingSymbol, Timeframe, 0, SwingLookback, low);
   CopyClose(TradingSymbol, Timeframe, 0, SwingLookback, close);
   
   if(copied < SwingLookback) return -1;
   
   // Determine trend direction
   bool uptrend = close[5] > close[10];
   bool downtrend = close[5] < close[10];
   
   // CHoCH in uptrend: Break of recent low
   if(uptrend) {
      double recentLow = low[ArrayMinimum(low, 2, 8)];
      if(low[0] < recentLow) {
         return OP_SELL; // Trend change to bearish
      }
   }
   
   // CHoCH in downtrend: Break of recent high
   if(downtrend) {
      double recentHigh = high[ArrayMaximum(high, 2, 8)];
      if(high[0] > recentHigh) {
         return OP_BUY; // Trend change to bullish
      }
   }
   
   return -1;
}

//+------------------------------------------------------------------+
//| Detect Liquidity Sweeps                                           |
//+------------------------------------------------------------------+
int DetectLiquiditySweeps() {
   double high[], low[], close[], open[];
   ArraySetAsSeries(high, true);
   ArraySetAsSeries(low, true);
   ArraySetAsSeries(close, true);
   ArraySetAsSeries(open, true);
   
   int copied = CopyHigh(TradingSymbol, Timeframe, 0, SwingLookback, high);
   CopyLow(TradingSymbol, Timeframe, 0, SwingLookback, low);
   CopyClose(TradingSymbol, Timeframe, 0, SwingLookback, close);
   CopyOpen(TradingSymbol, Timeframe, 0, SwingLookback, open);
   
   if(copied < SwingLookback) return -1;
   
   double swipeDistance = LiquiditySwipeDistance * 10 * Point;
   
   // Bullish liquidity sweep: Sweep below recent low then reverse up
   double recentLow = low[ArrayMinimum(low, 3, 10)];
   if(low[1] < (recentLow - swipeDistance) && close[0] > open[0] && close[0] > low[1]) {
      return OP_BUY;
   }
   
   // Bearish liquidity sweep: Sweep above recent high then reverse down
   double recentHigh = high[ArrayMaximum(high, 3, 10)];
   if(high[1] > (recentHigh + swipeDistance) && close[0] < open[0] && close[0] < high[1]) {
      return OP_SELL;
   }
   
   return -1;
}

//+------------------------------------------------------------------+
//| TRADE EXECUTION FUNCTIONS                                         |
//+------------------------------------------------------------------+

//+------------------------------------------------------------------+
//| Open buy trade                                                    |
//+------------------------------------------------------------------+
void OpenBuyTrade(double lotSize) {
   double entryPrice = Ask;
   double stopLoss = entryPrice - (StopLossPips * 10 * Point);
   double takeProfit = 0; // We manage TPs manually with partial closures
   
   int ticket = OrderSend(TradingSymbol, OP_BUY, lotSize, entryPrice, Slippage, stopLoss, takeProfit, 
                          "SMC ICT EA v4.0", MagicNumber, 0, clrGreen);
   
   if(ticket > 0) {
      Print("BUY order opened: Ticket=", ticket, " Lot=", lotSize, " Price=", entryPrice, " SL=", stopLoss);
      
      // Add to active trades
      int size = ArraySize(activeTrades);
      ArrayResize(activeTrades, size + 1);
      
      activeTrades[size].ticket = ticket;
      activeTrades[size].entryPrice = entryPrice;
      activeTrades[size].lotSize = lotSize;
      activeTrades[size].remainingLots = lotSize;
      activeTrades[size].type = OP_BUY;
      activeTrades[size].tp1Closed = false;
      activeTrades[size].tp2Closed = false;
      activeTrades[size].tp3Closed = false;
      activeTrades[size].tp4Closed = false;
   }
   else {
      Print("Error opening BUY order: ", GetLastError());
   }
}

//+------------------------------------------------------------------+
//| Open sell trade                                                   |
//+------------------------------------------------------------------+
void OpenSellTrade(double lotSize) {
   double entryPrice = Bid;
   double stopLoss = entryPrice + (StopLossPips * 10 * Point);
   double takeProfit = 0; // We manage TPs manually with partial closures
   
   int ticket = OrderSend(TradingSymbol, OP_SELL, lotSize, entryPrice, Slippage, stopLoss, takeProfit,
                          "SMC ICT EA v4.0", MagicNumber, 0, clrRed);
   
   if(ticket > 0) {
      Print("SELL order opened: Ticket=", ticket, " Lot=", lotSize, " Price=", entryPrice, " SL=", stopLoss);
      
      // Add to active trades
      int size = ArraySize(activeTrades);
      ArrayResize(activeTrades, size + 1);
      
      activeTrades[size].ticket = ticket;
      activeTrades[size].entryPrice = entryPrice;
      activeTrades[size].lotSize = lotSize;
      activeTrades[size].remainingLots = lotSize;
      activeTrades[size].type = OP_SELL;
      activeTrades[size].tp1Closed = false;
      activeTrades[size].tp2Closed = false;
      activeTrades[size].tp3Closed = false;
      activeTrades[size].tp4Closed = false;
   }
   else {
      Print("Error opening SELL order: ", GetLastError());
   }
}

//+------------------------------------------------------------------+
//| UTILITY FUNCTIONS                                                 |
//+------------------------------------------------------------------+

//+------------------------------------------------------------------+
//| Count open positions                                              |
//+------------------------------------------------------------------+
int CountOpenPositions() {
   int count = 0;
   for(int i = OrdersTotal() - 1; i >= 0; i--) {
      if(OrderSelect(i, SELECT_BY_POS, MODE_TRADES)) {
         if(OrderMagicNumber() == MagicNumber && OrderSymbol() == TradingSymbol) {
            count++;
         }
      }
   }
   return count;
}

//+------------------------------------------------------------------+
//| Remove active trade by index                                      |
//+------------------------------------------------------------------+
void RemoveActiveTradeByIndex(int index) {
   int size = ArraySize(activeTrades);
   if(index < 0 || index >= size) return;
   
   for(int i = index; i < size - 1; i++) {
      activeTrades[i] = activeTrades[i + 1];
   }
   
   ArrayResize(activeTrades, size - 1);
}

//+------------------------------------------------------------------+
//| Get status comment for display                                    |
//+------------------------------------------------------------------+
string GetStatusComment() {
   string comment = "";
   comment += "=== SMC ICT Scalping EA v4.0 ===\n";
   comment += "Symbol: " + TradingSymbol + " | Timeframe: M1\n";
   comment += "Account: " + DoubleToString(AccountBalance(), 2) + " " + AccountCurrency() + "\n";
   comment += "-----------------------------------\n";
   comment += "Daily P/L: " + DoubleToString(dailyProfit - dailyLoss, 2) + " IDR\n";
   comment += "Daily Profit: " + DoubleToString(dailyProfit, 2) + " IDR\n";
   comment += "Daily Loss: " + DoubleToString(dailyLoss, 2) + " IDR\n";
   comment += "Daily Limit Remaining: " + DoubleToString(DailyLossLimit - dailyLoss, 2) + " IDR\n";
   comment += "-----------------------------------\n";
   comment += "Total Trades: " + IntegerToString(totalTrades) + "\n";
   comment += "Wins: " + IntegerToString(winningTrades) + " | Losses: " + IntegerToString(losingTrades) + "\n";
   comment += "Win Rate: " + DoubleToString(currentWinRate, 2) + "%\n";
   comment += "Consecutive Losses: " + IntegerToString(consecutiveLosses) + "\n";
   comment += "-----------------------------------\n";
   comment += "Kill Zone: " + (IsInKillZone() ? "ACTIVE" : "Inactive") + "\n";
   comment += "Active Positions: " + IntegerToString(CountOpenPositions()) + "\n";
   comment += "-----------------------------------\n";
   comment += "Target 1 (" + DoubleToString(DailyTarget1, 0) + "): " + (dailyTarget1Reached ? "✓" : "○") + "\n";
   comment += "Target 2 (" + DoubleToString(DailyTarget2, 0) + "): " + (dailyTarget2Reached ? "✓" : "○") + "\n";
   comment += "Target 3 (" + DoubleToString(DailyTarget3, 0) + "): " + (dailyTarget3Reached ? "✓" : "○") + "\n";
   
   return comment;
}

//+------------------------------------------------------------------+
