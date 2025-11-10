# SMC ICT Scalping EA v4.0

## Overview
Complete rewrite of SMC ICT Scalping Expert Advisor v4.0 with comprehensive risk management, profit optimization, and automated adjustment features designed specifically for XAUUSD/GOLD trading on M1 timeframe.

## Features

### PHASE 1: STRICT RISK CONTROL ✓
- **Fixed Stop Loss**: Maximum 10 pips (no ATR multiplier)
- **Max Loss Per Trade**: 100,000 IDR equivalent
- **Daily Loss Limit**: 200,000 IDR 
- **Lot Size Safety**: 0.01-0.10 range with automatic enforcement
- **Risk-Based Position Sizing**: Automatic calculation based on account balance and risk parameters

### PHASE 2: PROFIT OPTIMIZATION ✓
- **Multi-Level Partial Close** (4 levels):
  - TP1: Entry + 5 pips → Close 20% of position
  - TP2: Entry + 10 pips → Close 30% of position
  - TP3: Entry + 15 pips → Close 30% of position
  - TP4: Entry + 20+ pips → Close 20% of position
- **Kill Zone Restriction**: 
  - London Session: 08:00-11:00 UTC
  - NY Session: 13:00-16:00 UTC
  - Off-peak trading disabled by default (configurable)
- **Session-Based Lot Sizing**:
  - London: 0.05 lots
  - NY: 0.05 lots
  - Off-peak: 0.01 lots
- **Entry Requirement**: Minimum 5 confluence points (configurable)

### PHASE 3: AUTO-ADJUSTMENT & MONITORING ✓
- **Win Rate Tracker**: Tracks last 20 trades
- **Dynamic Lot Sizing**:
  - >75% win rate: Increase lot to 0.06
  - 60-75% win rate: Maintain lot at 0.05
  - <60% win rate: Decrease lot to 0.03
- **Daily Target Alerts**: 300K, 400K, 500K IDR
- **Real-time P/L Monitoring**: Live display on chart
- **Auto-reduce on Losing Streak**: Reduces lot by 50% after 3+ consecutive losses

### SMC/ICT TECHNICAL FEATURES ✓
All industry-standard Smart Money Concepts and Inner Circle Trader methodologies:

1. **Order Blocks Detection**
   - Identifies institutional supply/demand zones
   - Detects strong rejection candles
   - Monitors price return to order block zones

2. **Fair Value Gap (FVG)**
   - Identifies imbalance zones in price action
   - Monitors gap-filling opportunities
   - Uses FVG as entry/exit zones

3. **Break of Structure (BOS)**
   - Detects swing high/low breaks
   - Confirms trend continuation
   - Triggers entries on structure breaks

4. **Change of Character (CHoCH)**
   - Identifies trend reversals
   - Monitors counter-trend structure breaks
   - Early reversal signal detection

5. **Liquidity Sweeps**
   - Detects stop-loss hunts
   - Identifies false breakouts
   - Confirms reversals after sweeps

## Technical Specifications

| Parameter | Value |
|-----------|-------|
| **Symbol** | XAUUSD/GOLD |
| **Timeframe** | M1 (1 Minute) |
| **Account Size** | 500,000 IDR |
| **Daily Target** | 500,000 IDR minimum |
| **Magic Number** | 888888 |
| **Version** | 4.0 |
| **Slippage** | 3 points |

## Installation

### For MetaTrader 4:
1. Copy `SMC_ICT_Scalping_EA_v4.0.mq4` to your MT4 data folder:
   - `File → Open Data Folder → MQL4 → Experts`
2. Restart MetaTrader 4 or click "Refresh" in Navigator
3. Drag the EA onto XAUUSD M1 chart
4. Enable AutoTrading (press F7 or click the button)

### For MetaTrader 5:
1. Copy `SMC_ICT_Scalping_EA_v4.0.mq5` to your MT5 data folder:
   - `File → Open Data Folder → MQL5 → Experts`
2. Restart MetaTrader 5 or click "Compile" in MetaEditor
3. Drag the EA onto XAUUSD M1 chart
4. Enable Algo Trading

## Configuration

### Risk Management Settings
```
StopLossPips = 10.0          // Fixed stop loss in pips
MaxLossPerTrade = 100000     // Maximum loss per trade (IDR)
DailyLossLimit = 200000      // Daily loss limit (IDR)
MinLotSize = 0.01            // Minimum lot size
MaxLotSize = 0.10            // Maximum lot size
```

### Profit Optimization Settings
```
TP1_Pips = 5.0               // First take profit level
TP1_Percent = 20.0           // Percentage to close at TP1
TP2_Pips = 10.0              // Second take profit level
TP2_Percent = 30.0           // Percentage to close at TP2
TP3_Pips = 15.0              // Third take profit level
TP3_Percent = 30.0           // Percentage to close at TP3
TP4_Pips = 20.0              // Fourth take profit level
TP4_Percent = 20.0           // Percentage to close at TP4

EnableKillZone = true        // Enable/disable kill zone restriction
LondonStartHour = 8          // London session start (UTC)
LondonEndHour = 11           // London session end (UTC)
NYStartHour = 13             // NY session start (UTC)
NYEndHour = 16               // NY session end (UTC)

MinConfluencePoints = 5      // Minimum confluence required for entry
```

### Auto-Adjustment Settings
```
WinRateTrackingPeriod = 20   // Number of trades to track
HighWinRateThreshold = 75.0  // High win rate threshold (%)
MediumWinRateThreshold = 60.0// Medium win rate threshold (%)
HighWinRateLot = 0.06        // Lot for high win rate
MediumWinRateLot = 0.05      // Lot for medium win rate
LowWinRateLot = 0.03         // Lot for low win rate

LosingStreakThreshold = 3    // Consecutive losses before reduction
DailyTarget1 = 300000        // First daily target (IDR)
DailyTarget2 = 400000        // Second daily target (IDR)
DailyTarget3 = 500000        // Third daily target (IDR)
```

### SMC/ICT Settings
```
EnableOrderBlocks = true     // Enable order blocks detection
EnableFVG = true             // Enable fair value gaps
EnableBOS = true             // Enable break of structure
EnableCHoCH = true           // Enable change of character
EnableLiquiditySweep = true  // Enable liquidity sweeps

OrderBlockLookback = 50      // Bars to analyze for order blocks
FVGLookback = 30             // Bars to analyze for FVG
SwingLookback = 20           // Bars for swing points
LiquiditySwipeDistance = 5.0 // Distance for liquidity detection (pips)
```

## Usage Guide

### Starting the EA
1. Ensure you have a live or demo account with at least 500,000 IDR
2. Open XAUUSD/GOLD chart and set timeframe to M1
3. Attach the EA to the chart
4. Configure parameters as needed
5. Enable AutoTrading/Algo Trading
6. Monitor the on-chart display for real-time statistics

### On-Chart Display
The EA displays comprehensive information:
```
=== SMC ICT Scalping EA v4.0 ===
Symbol: XAUUSD | Timeframe: M1
Account: 500000.00 IDR
-----------------------------------
Daily P/L: 150000.00 IDR
Daily Profit: 175000.00 IDR
Daily Loss: 25000.00 IDR
Daily Limit Remaining: 175000.00 IDR
-----------------------------------
Total Trades: 15
Wins: 12 | Losses: 3
Win Rate: 80.00%
Consecutive Losses: 0
-----------------------------------
Kill Zone: ACTIVE
Active Positions: 1
-----------------------------------
Target 1 (300000): ○
Target 2 (400000): ○
Target 3 (500000): ○
```

### Understanding Confluence Points
The EA requires a minimum number of confluence signals before entering a trade:

- **Order Block Detected**: +1 point
- **Fair Value Gap**: +1 point
- **Break of Structure**: +1 point
- **Change of Character**: +1 point
- **Liquidity Sweep**: +1 point

Minimum 5 points required for entry (default, configurable).

### Risk Management Features

#### Automatic Position Sizing
- Calculates lot size based on risk per trade
- Considers account balance and stop loss distance
- Enforces minimum and maximum lot sizes
- Adjusts for broker's lot step requirements

#### Daily Loss Protection
- Monitors all trades throughout the day
- Stops trading when daily loss limit reached
- Resets automatically at the start of new trading day
- Displays remaining daily risk budget

#### Losing Streak Protection
- Detects consecutive losses automatically
- Reduces lot size by 50% after 3+ losses
- Prevents compounding of losses
- Returns to normal sizing after winning trade

### Partial Take Profit System

The EA implements a sophisticated 4-level partial closure system:

1. **TP1 (5 pips)**: Closes 20% of position
   - Secures initial profit
   - Reduces risk to zero or small profit

2. **TP2 (10 pips)**: Closes 30% of position
   - Locks in significant profit
   - Allows remainder to run

3. **TP3 (15 pips)**: Closes 30% of position
   - Maximizes profit capture
   - Maintains exposure for big moves

4. **TP4 (20+ pips)**: Closes remaining 20%
   - Captures extended moves
   - Exits full position

### Kill Zone Trading

**London Session (08:00-11:00 UTC)**
- High volatility
- Major liquidity
- Uses 0.05 lot size
- Best for scalping

**NY Session (13:00-16:00 UTC)**
- Highest volume period
- Strong directional moves
- Uses 0.05 lot size
- Optimal trading window

**Off-Peak Hours**
- Low volatility
- Reduced lot size (0.01)
- Can be disabled via settings

## Performance Optimization

### Recommended Settings for Different Account Sizes

#### 500K IDR Account (Default)
```
MaxLossPerTrade = 100000
DailyLossLimit = 200000
MinLotSize = 0.01
MaxLotSize = 0.10
```

#### 1M IDR Account
```
MaxLossPerTrade = 200000
DailyLossLimit = 400000
MinLotSize = 0.02
MaxLotSize = 0.20
```

#### 2M IDR Account
```
MaxLossPerTrade = 400000
DailyLossLimit = 800000
MinLotSize = 0.04
MaxLotSize = 0.40
```

### Optimization Tips

1. **Conservative Settings** (Lower Risk):
   - Increase MinConfluencePoints to 6-7
   - Reduce MaxLotSize to 0.05
   - Enable only OrderBlocks and FVG

2. **Aggressive Settings** (Higher Risk/Reward):
   - Decrease MinConfluencePoints to 3-4
   - Increase MaxLotSize to 0.15
   - Enable all SMC/ICT features

3. **Scalping Focused**:
   - Set TP1_Pips to 3
   - Increase TP1_Percent to 40
   - Trade only during kill zones

## Monitoring & Alerts

### Daily Target Alerts
The EA will send alerts when reaching:
- Target 1: 300,000 IDR
- Target 2: 400,000 IDR
- Target 3: 500,000 IDR

### Risk Alerts
- Daily loss limit approaching
- Losing streak detected (3+ losses)
- Kill zone status changes

### Trade Notifications
- Entry signals with confluence count
- Partial closures at each TP level
- Trade outcomes (win/loss)

## Troubleshooting

### EA Not Trading
1. Check if AutoTrading/Algo Trading is enabled
2. Verify account has sufficient balance
3. Confirm you're on XAUUSD M1 chart
4. Check if kill zone restriction is limiting trades
5. Verify confluence points are being met

### Positions Not Closing at TP Levels
1. Check broker spread
2. Verify slippage settings
3. Ensure minimum lot size requirements met
4. Check if partial closure is calculated correctly

### Daily Loss Limit Issues
1. Verify currency conversion is correct
2. Check if multiple EAs are running
3. Ensure magic number is unique
4. Review historical trades in terminal

### High Slippage
1. Trade during kill zones for better liquidity
2. Increase slippage parameter
3. Consider using VPS for faster execution
4. Check broker execution quality

## Best Practices

1. **Start with Demo Account**
   - Test settings for at least 1 week
   - Monitor win rate and drawdown
   - Adjust parameters based on results

2. **Use VPS for 24/7 Trading**
   - Ensures EA runs continuously
   - Reduces latency
   - Prevents missed opportunities

3. **Regular Monitoring**
   - Check daily performance
   - Review trade history weekly
   - Adjust settings based on market conditions

4. **Risk Management**
   - Never risk more than you can afford to lose
   - Keep daily loss limit at 40% of account or less
   - Maintain proper position sizing

5. **Market Conditions**
   - EA works best in trending markets
   - May underperform in choppy/ranging conditions
   - Consider pausing during major news events

## Version History

### v4.0 (Current)
- Complete rewrite from scratch
- Added 4-level partial TP system
- Implemented kill zone restrictions
- Added dynamic lot sizing
- Win rate tracking and adjustment
- Comprehensive SMC/ICT analysis
- Real-time monitoring and alerts
- Losing streak protection
- Daily target tracking

## Support & Contact

For issues, suggestions, or support:
- Repository: https://github.com/zerxenzon/penjadwalan-otomatis
- Create an issue in the repository for bug reports
- Include log files and screenshots for faster support

## Disclaimer

**IMPORTANT RISK DISCLOSURE:**

Trading foreign exchange and contracts for differences on margin carries a high level of risk and may not be suitable for all investors. The high degree of leverage can work against you as well as for you. Before deciding to trade foreign exchange or any other financial instrument, you should carefully consider your investment objectives, level of experience, and risk appetite.

This Expert Advisor is provided "as-is" without any warranties. Past performance is not indicative of future results. The developer is not responsible for any financial losses incurred while using this EA.

**USE AT YOUR OWN RISK.**

## License

Copyright 2025 zerxenzon. All rights reserved.

---

**SMC ICT Scalping EA v4.0** - Professional Automated Trading System
